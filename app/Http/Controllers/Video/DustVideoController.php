<?php

namespace App\Http\Controllers\Video;

use App\Models\Dust;
use App\Models\DustCode;
use App\models\DustInfo;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DustVideoController extends Controller
{
    public function index(Request $request)
    {
        // 项目名称筛选
        $itemWhere = function($query) use ($request) {
            if ($request->has('item_name') && trim($request->item_name != '')) {
                $query->where('name', 'like', '%'.$request->item_name.'%');
            }
        };

        // 施工单位筛选
        $buildUnitWhere = function($query) use ($request) {
            if ($request->has('unit_name') && trim($request->unit_name != '')) {
                $query->where('name', 'like', '%'.$request->unit_name.'%');
            }
        };

        // 扬尘sn、是否在线、有无报警筛选
        $dustWhere = function($query) use ($request) {
            if ($request->has('sn') && trim($request->sn != '')) {
                $query->where('sn', 'like', '%'.$request->sn.'%');
            }

            if ($request->has('is_online') && trim($request->is_online != '')) {
                $query->where('is_online', $request->is_online);
            }

            if ($request->has('cur_warn_count') && trim($request->cur_warn_count != '')) {
                $query->where('cur_warn_count', $request->cur_warn_count);
            }
        };

        // 关联模型条件查询
        $items =  Item::with(['dusts' => function($query) use ($dustWhere) {
            $query->select('item_id','sn','is_online','pre_warn_count','cur_warn_count')->where($dustWhere);
        }, 'buildUnit' => function($query) use ($buildUnitWhere) {
            $query->where($buildUnitWhere);
        }])->where($itemWhere)
            ->orderBy('created_at', 'desc')->select('id', 'name', 'item_no', 'permit_no')->paginate(30);

        // 过滤掉 buildUnit 或者 dusts 为空的item
        $items = $items->filter(function($value) {
            return $value->buildUnit->all() && $value->dusts->all();
        });

        foreach($items as $key => &$value) {
            $value['b_unit'] = $value->buildUnit->implode('name');
            $value['online_count'] = $value->dusts->sum('is_online');
            $value['pre_warning_count'] = $value->dusts->sum('pre_warn_count');
            $value['is_warning_count'] = $value->dusts->sum('cur_warn_count');
            unset($value->buildUnit);
        }


        return successJson($items);

    }

    public function workingData(Request $request) {
        // 如果参数里带有时间，并且是有值得
        $where = function($query) use ($request) {
            if($request->has('time') && trim($request->time) != '') {
                $time = explode(',', $request->time);

                // 如果 $time 是一个时间点
                if (count($time) == 1) {
                    $query->where('received_at', '>=' ,$time[0]);
                }
                // 如果 $time 是一个时间段
                else {
                    $query->where('received_at', '>=' ,$time[0])->where('received_at', '<=' ,$time[0]);
                }
            }
        };

        $pagesize = $request->pagesize or 30;
        $dustInfos = DustInfo::with('dust:sn,monitor_place_name')->where('sn', $request->sn)->where($where)->paginate($pagesize);

        return $dustInfos;
    }

    public function warn(Request $request) {
        // 如果参数里带有时间，并且是有值得
        $where = function($query) use ($request) {
            if($request->has('time') && trim($request->time) != '') {
                $time = explode(',', $request->time);

                // 如果 $time 是一个时间点
                if (count($time) == 1) {
                    $query->where('received_at', '>=' ,$time[0]);
                }
                // 如果 $time 是一个时间段
                elseif(count($time) == 2) {
                    $query->where('received_at', '>=' ,$time[0])->where('received_at', '<=' ,$time[0]);
                }
            }

            // 报警或者预警状态
            if ($request->has('warning_status') && $request->is_warning_status) {
                // 如果是报警
                if ($request->warning_status == 'is_warning_status') {
                    $query->where('is_warning_status', 1);
                } elseif($request->warning_status == 'pre_warning_status') {
                    $query->where('pre_warning_status', 1);
                }
            }

            // 报警类型
            if ($request->has('warning_type') && $type = $request->warning_type) {
                switch($type) {
                    case 'a34001_Rtd_is_warning' :  // 扬尘上限
                        $query->where('a34001_Rtd_is_warning', 1);
                        break;
                    case 'a34002_Rtd_is_warning' :  // PM10上限
                        $query->where('a34002_Rtd_is_warning', 1);
                        break;
                    case 'a34004_Rtd_is_warning' :  //PM2.5上限
                        $query->where('a34004_Rtd_is_warning', 1);
                        break;
                    case 'LA_Rtd_is_warning' :  //  噪音上限
                        $query->where('LA_Rtd_is_warning', 1);
                        break;
                    case 'a01001_Rtd_high_is_warning' : // 温度上限
                        $query->where('a01001_Rtd_high_is_warning', 1);
                        break;
                    case 'a01001_Rtd_low_is_warning' :  // 温度下限
                        $query->where('a01001_Rtd_low_is_warning', 1);
                        break;
                    case 'a01002_Rtd_is_warning' :  //湿度上限
                        $query->where('a01002_Rtd_is_warning', 1);
                        break;
                    case 'a01006_Rtd_high_is_warning' :  //气压上限
                        $query->where('a01006_Rtd_high_is_warning', 1);
                        break;
                    case 'a01006_Rtd_low_is_warning' :  //气压下限
                        $query->where('a01006_Rtd_low_is_warning', 1);
                        break;
                    case 'a01007_Rtd_is_warning' :  //风速上限
                        $query->where('a01007_Rtd_is_warning', 1);
                        break;
                }
            }
        };

        $pagesize = $request->pagesize or 30;
        $dustInfos = DustInfo::with('dust:sn,monitor_place_name')->where('sn', $request->sn)->where($where)->paginate($pagesize);

        return $dustInfos;
    }

    public function workingTime(Request $request)
    {
        $where = function($query) use ($request) {
            if ($request->has('time') && trim($request->time) != '') {
                $time = explode(',', $request->time);

                // 如果 $time 是一个时间点
                if (count($time) == 1) {
                    $query->where('created_at', '>=', $time[0]);
                } // 如果 $time 是一个时间段
                elseif (count($time) == 2) {
                    $query->where('created_at', '>=', $time[0])->where('created_at', '<=', $time[0]);
                }
            }else {
                $query->where('created_at', '>=', Carbon::today());
            }
        };

        $pagesize = $request->pagesize or 30;
        $dusts = DustCode::with('dust:sn,monitor_place_name')->where($where)->orderBy('id', 'desc')->paginate($pagesize);

        forEach($dusts as &$dust) {
            $diffTime = strtotime($dust->updated_at) - strtotime($dust->created_at);
            if ($diffTime >= 3600) {
                $dust->time = floor($diffTime / 3600) .'小时'.floor(($diffTime % 3600) / 60).'分钟';
            } else {
                $dust->time = floor(($diffTime % 3600) / 60).'分钟';
            }

        }

        return $dusts;
    }


}

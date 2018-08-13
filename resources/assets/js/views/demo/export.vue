<template>
    <div>
        123
    </div>
</template>

<script>
import axios from '../../utils/request'
    export default {
        data() {
            return {
                data: {
                    item_id: 3,
                    right_unit_id: 3,
                    produce_unit_id: 3,
                    is_monitor: 3,
                    driver: 3,
                    record_no: '123',
                    floor_no: '1#',
                    model: '123',
                    left_no: '12321312',
                    parameters: "a: {a:1}",
                    left_at: '2018-02-12 23:22:11',
                    install_unit_id: parseInt('1'),
                    sn: '555555',
                    GPRS: '32323232',
                    validity_month: 12,
                    model: 1111,
                    paid_at: '2018-02-12 23:22:11',
                    installed_at: '2018-02-12 23:22:11',
                    function_config: 'a: {a:1}',
                    identify: 'a: {a:1}',
                }
            }
        },

        created() {
            axios({
                url: `/crane/5`,
                method: 'patch',
                data: this.data
            }).then(res => {
                console.log(res)
            })
        }
    }
</script>
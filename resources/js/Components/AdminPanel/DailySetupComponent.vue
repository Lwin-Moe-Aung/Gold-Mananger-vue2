<template>
    <div>
        <div class="form-group">
            <!-- <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="customRadio1" :checked="radio_old_daily_Setup" @click="changeDailySetupOption()">
                <label for="customRadio1" class="custom-control-label">အရင် purchase လုပ်တုန်းကပေါက်ဈေး({{ numberWithCommas(daily_setup_list[16].kyat) }} .ကျပ်)</label>
            </div> -->
            <div class="custom-control custom-radio">
                <!-- <input class="custom-control-input" type="radio" id="customRadio2" :checked="!radio_old_daily_Setup" @click="changeDailySetupOption()">
                <label for="customRadio2" class="custom-control-label">ယနေ့ နောက်ဆုံးပေါက်ဈေး({{ numberWithCommas($page.props.daily_setup[16].kyat) }}.ကျပ်) </label> -->
                <label>ယနေ့ နောက်ဆုံးပေါက်ဈေး({{ numberWithCommas($page.props.daily_setup[16].kyat) }}.ကျပ်) </label>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" v-model="daily_Setup.kyat" @change="editDailySetup" :disabled="daily_Setup.kyat == ''">
                <span class="input-group-append">
                    <button type="button" class="btn btn-success btn-flat text-white"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    props: ["quality","placeholder"],
    created() {
    },
    data() {
        return {
            daily_Setup: { daily_setup_id: "", quality_16_pal: "", kyat: "", pal: "", yway: "" },
        }
    },
    watch: {
        quality (val) {
            if(val != null){
                this.daily_Setup = this.$page.props.daily_setup[val];
            }else{
                this.daily_Setup = { daily_setup_id: "", quality_16_pal: "", kyat: "", pal: "", yway: "" };
            }
        },
    },
    methods: {
        numberWithCommas(value) {
            if(typeof value !== "undefined"){
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        editDailySetup() {
            if(this.daily_Setup.kyat <= 1000 ){
                alert('daily price must be greater than "1000"');
                return;
            };
            let q = parseInt(this.quality);
            let kyat = parseInt(this.daily_Setup.kyat);
            let pal = kyat / q;
            let yway = pal / 8;
            this.daily_Setup.daily_setup_id = "";
            this.daily_Setup.quality_16_pal = pal * (q+(16-q));
            this.daily_Setup.kyat = kyat;
            this.daily_Setup.pal = pal;
            this.daily_Setup.yway = yway;

            this.$emit('update:data', this.daily_Setup);
        },
    }
}
</script>

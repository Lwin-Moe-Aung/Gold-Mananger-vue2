<template>
     <div>
    <!-- Content Header (Page header) -->
    <div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
     <div class="row">
         <div class="col-4">

        </div>
        <div class="col-4 text-center">
        <h5>
            <i class="fas fa-gold"></i> {{ transaction.business.name }} / {{ transaction.business_location.name }}
        </h5>
        <p> {{transaction.business_location.address}}</p>
        <p> {{transaction.business_location.mobile}}</p>
        <p> {{transaction.business_location.email}}</p>

        </div>
        <div class="col-4">
            <small class="float-right">Date: {{ dateTime(transaction.transaction_date)}}</small>

        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
     <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
        Customer Info
        <address>
            <strong>{{transaction.contact.name}}</strong><br>
            {{transaction.contact.address}}<br>
            Phone: {{transaction.contact.mobile1}},{{transaction.contact.mobile2}}<br>
            Email: {{transaction.contact.email}}
        </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <b>Invoice #{{transaction.invoice_no}}</b><br>
        <br>
        <b>Payment Due:</b> {{ dateTime(transaction.transaction_date)}}<br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <b>ပစ္စည်းအမည် :    {{item.name}}</b>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">


        </div>
        <!-- /.col -->
    </div>

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped" ref="printTable">
                <thead>
                    <tr>
                        <th>အမျိုးအစား</th>
                        <th>ကျပ်</th>
                        <th>ပဲ </th>
                        <th>ရွေး</th>
                        <th>တန်ဖိုး</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ရွှေချိန်</td>
                        <td>{{item.gold_weight.kyat}}</td>
                        <td>{{item.gold_weight.pal}}</td>
                        <td>{{item.gold_weight.yway}}</td>
                        <td>{{item.gold_price}}</td>
                    </tr>
                    <tr>
                        <td>ကျောက်ချိန်</td>
                        <td>{{item.gem_weight.kyat}}</td>
                        <td>{{item.gem_weight.pal}}</td>
                        <td>{{item.gem_weight.yway}}</td>
                        <td>{{item.gem_price}}</td>
                    </tr>
                    <tr>
                        <td>အလျော့တွက်</td>
                        <td>{{item.fee.kyat}}</td>
                        <td>{{item.fee.pal}}</td>
                        <td>{{item.fee.yway}}</td>
                        <td>{{item.fee_price}}</td>
                    </tr>
                    <tr>
                        <td>လက်ခ</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{item.fee_for_making}}</td>
                    </tr>
                    <tr>
                        <td>စုစုပေါင်း</td>
                        <td>{{order.total_weight.kyat}}</td>
                        <td>{{order.total_weight.pal}}</td>
                        <td>{{order.total_weight.yway}}</td>
                        <td>{{order.total_before}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">

        </div>
        <!-- /.col -->
        <div class="col-6">
            <p class="lead">Amount Due {{ dateTime(transaction.transaction_date)}}</p>

            <div class="table-responsive">
                <table class="table">
                <tr>
                    <th style="width:50%">လျော့ငွေ:</th>
                    <td>{{order.discount_amount}}</td>
                </tr>
                <tr>
                    <th>ကျသင့်ငွေ</th>
                    <td>{{order.final_total}}</td>
                </tr>
                <tr>
                    <th>ပေးငွေ:</th>
                    <td>{{order.paid_money}}</td>
                </tr>
                <tr>
                    <th>ကျန်ငွေ:</th>
                    <td>{{order.credit_money}}</td>
                </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <div class="row no-print">
        <div class="col-12">
        <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>

        </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
    <!-- /.content -->
  </div>
</template>
<script>
    import moment from 'moment';

    export default {
        name: 'Invoice',
        props: [
            'order',
            'transaction',
            'item',
            'product'
            ],
        created() {
            this.printbill();
            // console.log("hello invoice page");
            // window.addEventListener("load", window.print());
        },
        methods: {
            printbill() {
                window.print();
            },
            dateTime(value) {
                return moment(value).format('DD/MM/YYYY');
            }
        }

    }
</script>
<style>
@media print {
	.no-print  {
		display: none;
	}

}
</style>

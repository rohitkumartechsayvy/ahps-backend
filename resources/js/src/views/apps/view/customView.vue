<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form>
          <div class="form-group">
            <label>Name</label>
            <vs-input
              class="w-full form-control"
              type="text"
              name="name"
              v-validate="'min:6|max:10'"
              v-model="name"
            />
          </div>
          <div class="form-group">
            <label>Description</label>
            <vs-input
              class="w-full form-control"
              type="text"
              name="desc"
              v-validate="'min:6|max:10'"
              v-model="desc"
            />
          </div>

          <div class="form-group">
            <label>Price</label>
            <vs-input
              class="w-full form-control"
              type="number"
              name="price"
              v-validate="'min:6|max:10'"
              v-model="price"
            />
          </div>
          <button @click="makePayment" class="btn btn-success">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "home",
  components: {},
  data() {
    return {
      price: 0,
      order_id: "RYRTRYTR",
      name: "",
      desc: "",
    };
  },
  methods: {
    //Function to create order ID
    makePayment: function (ev) {
      ev.preventDefault();
      var data = {};
      (data["name"] = this.name),
        (data["desc"] = this.desc),
        (data["amount"] = 500),
        axios({
          method: "post",
          url: "http://127.0.0.1:8000/custom-view",
          data: data,
        })
          .then((res) => {
            this.order_id = "NEWORDER";
            //Initiation of Razorpay PG
            var rzp1 = new Razorpay({
              key: "rzp_live_sqUn77hYRrDzwX",
              amount: 100,
              name: "Anju Sharma",
              currency: "INR",
              description: "Dscbkngjnbgn",
              image: "Link Of Image",
              //Uncomment if you are using handler function
              // "handler": function (response){
              //   alert(response.razorpay_payment_id);
              // },
              //callback_url: 'http://13.126.183.214/razorpay/checkstatus/?orderid='+this.order_id,
              prefill: {
                name: "Anju Sharma",
                email: "anju.sharma045@gmail.com",
              },
              notes: {
                address: "",
              },
              theme: {
                color: "#00ffff",
              },
              order_id: res.data.order_id,
              callback_url: "http://domain.com/#/about/" + this.order_id,
              redirect: true,
            });
            rzp1.open();
          })
          .catch((err) => {
            console.log("ERR", err);
          });
    },
    //if you are using handler function
    // verify: function(response) {
    // }
  },
};
</script>
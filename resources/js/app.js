import './bootstrap';
import {get, post} from './http'

import Alpine from 'alpinejs';
window.Alpine = Alpine;


document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    openModal: false,
    currentFilling: {},
    totalPrice: null,
    totalAmount: null,
    getActualAmount(param){
      return param.type.weight_quantity === 'weight' ? param.min_weight : param.min_quantity;
    },
    handleOpenModal(filling){
      this.currentFilling = filling
      this.openModal = true
      this.totalAmount = this.getActualAmount(filling)
      this.totalPrice = filling.unit_price * this.getActualAmount(filling)
    },
    
})



  Alpine.data('index', () => ({
    
  }))

  Alpine.data('modal', () => ({
    isShownGoToCart: false,
    closeModal(){
      this.$store.cart.openModal = false
      this.isShownGoToCart = false
    },
    plusItemWeight(){
      this.$store.cart.totalAmount = +this.$store.cart.totalAmount + 0.5
      this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
    },
    minusItemWeight(){
      if(this.$store.cart.totalAmount > this.$store.cart.currentFilling.min_weight){
        this.$store.cart.totalAmount = +this.$store.cart.totalAmount - 0.5
        this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
      }  
    },
    plusItemQuantity(){
      this.$store.cart.totalAmount++
      this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
    },
    minusItemQuantity(){
      if(this.$store.cart.totalAmount > this.$store.cart.currentFilling.min_quantity){
        --this.$store.cart.totalAmount
        this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
      }
    },
    addToCart(){
      post('/cart/add/'+this.$store.cart.currentFilling.id, {
        totalAmount: this.$store.cart.totalAmount,
        totalPrice: this.$store.cart.totalPrice,
      })
        .then(res => {
          this.$dispatch('cart-change', {count: res.count})
          this.isShownGoToCart = true
          console.log(res)
        })
    }
  }))
  
})

Alpine.start();
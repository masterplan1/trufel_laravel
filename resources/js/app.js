import './bootstrap';
import { get, post } from './http'

import Alpine from 'alpinejs';
window.Alpine = Alpine;

const OFFSET_STEP = 6;

document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    openModal: false,
    currentFilling: {},
    totalPrice: null,
    totalAmount: null,
    getActualAmount(param) {
      return param.type.weight_quantity === 'weight' ? param.min_weight : param.min_quantity;
    },
    handleOpenModal(filling) {
      this.currentFilling = filling
      this.openModal = true
      this.totalAmount = this.getActualAmount(filling)
      this.totalPrice = filling.unit_price * this.getActualAmount(filling)
    },

  })



  Alpine.data('handleCart', (filling) => ({
    filling,
    candybarFillingId: null,
    getHeaderTitle() {
      return this.filling.category.type.is_candybar ? this.filling.category.name : this.filling.category.type.name
    },
    getFillingTitle() {
      return this.filling.category.type.is_candybar ? this.filling.category.name : this.filling.title
    },
    handleWeightIncrease() {
      this.filling.weight = +this.filling.weight + 0.5
      post(filling.updateUrl, {
        'totalAmount': this.filling.quantity,
      }).then(res => this.$dispatch('cart-change', { count: res.count }))
    },
    handleWeightDecrease() {
      if (this.filling.weight > this.filling.min_weight) {
        this.filling.weight = +this.filling.weight - 0.5
        post(filling.updateUrl, {
          'totalAmount': this.filling.quantity,
        }).then(res => this.$dispatch('cart-change', { count: res.count }))
      }
    },
    handleQuantityIncrease() {
      this.filling.quantity = +this.filling.quantity + 1
      post(filling.updateUrl, {
        'totalAmount': this.filling.quantity,
      }).then(res => this.$dispatch('cart-change', { count: res.count }))
    },
    handleQuantityDecrease() {
      if (this.filling.quantity > this.filling.min_quantity) {
        this.filling.quantity = +this.filling.quantity - 1
        post(filling.updateUrl, {
          'totalAmount': this.filling.quantity,
        }).then(res => this.$dispatch('cart-change', { count: res.count }))
      }
    },
    removeItemFromCart() {
      post(filling.removeUrl, {
        'totalAmount': this.filling.quantity,
      }).then(res => {
        this.$dispatch('cart-change', { count: res.count })
        this.cartItems = this.cartItems.filter(i => i.id !== this.filling.id)
      })
    },
    handleFillingSelecet() {
      post(filling.changeUrl, { 'new_filling_id': this.candybarFillingId })
    }
  }))

  Alpine.data('modal', () => ({
    candybarFillingId: null,
    // this?.$store.cart.currentFilling.fillings[0]
    // candybarFillingId: this?.$store.cart.currentFilling.type?.is_candybar ? 
    //   this?.$store.cart.currentFilling.fillings[0].id : null,
    isShownGoToCart: false,
    closeModal() {
      this.$store.cart.openModal = false
      this.isShownGoToCart = false
    },
    plusItemWeight() {
      this.$store.cart.totalAmount = +this.$store.cart.totalAmount + 0.5
      this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
    },
    minusItemWeight() {
      if (this.$store.cart.totalAmount > this.$store.cart.currentFilling.min_weight) {
        this.$store.cart.totalAmount = +this.$store.cart.totalAmount - 0.5
        this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
      }
    },
    plusItemQuantity() {
      this.$store.cart.totalAmount++
      this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
    },
    minusItemQuantity() {
      if (this.$store.cart.totalAmount > this.$store.cart.currentFilling.min_quantity) {
        --this.$store.cart.totalAmount
        this.$store.cart.totalPrice = this.$store.cart.totalAmount * this.$store.cart.currentFilling.unit_price
      }
    },
    addToCart() {
      if (this.$store.cart.currentFilling.type.is_candybar && this.candybarFillingId === null) {
        this.candybarFillingId = this.$store.cart.currentFilling.fillings[0].id
      }
      const id = this.candybarFillingId ?? this.$store.cart.currentFilling.id
      post('/cart/add/' + id, {
        totalAmount: this.$store.cart.totalAmount,
        // totalPrice: this.$store.cart.totalPrice,
      })
        .then(res => {
          this.$dispatch('cart-change', { count: res.count })
          this.isShownGoToCart = true
          console.log(res)
        })
    },
  }))

  Alpine.data('fillingItem', (fillings, type_id) => ({
    fillings,
    categoryWasSelected: false,
    additionFillings: [],
    type_id,
    categoryId: 0,
    offset: OFFSET_STEP,
    addFillings() {
      post('/add-fillings/' + type_id, {
        offset: this.offset,
        category_id: this.categoryId
      })
        .then(res => {
          this.offset += OFFSET_STEP
          this.additionFillings = [...this.additionFillings, ...res]
          console.log(res)
        })
    },
    selectCategory(id) {
      if (this.categoryId !== id) {
        this.categoryWasSelected = true
        // todo active category font
        this.categoryId = id
        this.additionFillings = []
        this.offset = 0
        this.addFillings()
      }
    }
  }))
})

Alpine.start();
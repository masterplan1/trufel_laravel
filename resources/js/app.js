import './bootstrap';
import { get, post } from './http'
import flatpickr from "flatpickr";

import Alpine from 'alpinejs';
import Mask from "@ryangjchandler/alpine-mask";
import intersect from '@alpinejs/intersect'
Alpine.plugin(Mask);
Alpine.plugin(intersect)
window.Alpine = Alpine;

const OFFSET_STEP = 6;

document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    openModal: false,
    currentFilling: {},
    totalPrice: null,
    totalAmount: null,
    getActualAmount(param) {
      return param.type_weight_quantity === 'weight' ? param.min_weight : param.min_quantity;
    },
    handleOpenModal(filling) {
      this.currentFilling = filling
      this.openModal = true
      this.totalAmount = this.getActualAmount(filling)
      this.totalPrice = filling.unit_price * this.getActualAmount(filling)
    },

  })

  Alpine.data('orderItem', (time) => ({
    init(){
      flatpickr("#datePickerId", {
        minDate: time
      })
    },
  }))

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
    isCandybarSelectDisabled: false,

    isShownGoToCart: false,
    closeModal() {
      this.$store.cart.openModal = false
      this.isShownGoToCart = false
      this.isCandybarSelectDisabled = false
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
      if (this.$store.cart.currentFilling.type_is_candybar && this.candybarFillingId === null) {
        this.candybarFillingId = this.$store.cart.currentFilling.fillings[0].id
      }
      const id = this.candybarFillingId ?? this.$store.cart.currentFilling.id
      post('/cart/add/' + id, {
        totalAmount: this.$store.cart.totalAmount,
      })
        .then(res => {
          this.$dispatch('cart-change', { count: res.count })
          this.isShownGoToCart = true
          this.isCandybarSelectDisabled = true
        })
    },
  }))

  Alpine.data('fillingItem', (fillings, type, countItems) => ({
    fillings,
    countItems,
    categoryWasSelected: false,
    additionFillings: [],
    type_id: type.id,
    categoryId: 0,
    offset: OFFSET_STEP,
    activeClassCategory: null,
    countHandler(){
      return this.countItems > Object.keys(this.fillings).length + this.additionFillings.length
    },
    prepareFillingForCandybar(item){
      return item.fillings[Object.keys(item.fillings)[0]]
    },
    addFillings() {
      const url = type.is_candybar === 0 ? '/add-fillings/' : '/add-categories/'
      post(url + this.type_id, {
        offset: this.offset,
        category_id: this.categoryId
      })
        .then(res => {
          this.offset += OFFSET_STEP
          this.additionFillings = [...this.additionFillings, ...res.fillings]
          this.countItems = res.items_count === 0 ? countItems : res.items_count
        })
    },
    selectCategory(id, key = null) {
      if (this.categoryId !== id && type.is_candybar === 0) {
        this.categoryWasSelected = true
        this.fillings = {}
        this.categoryId = id
        this.additionFillings = []
        this.offset = 0
        this.addFillings()
        this.activeClassCategory = key
      }
    },
    chooseWeightQuantity(f){
      const isWeight = f.type_weight_quantity === 'weight'
      return isWeight ? `${f.min_weight} кг` : `${f.min_quantity} шт`
    }
  }))

  Alpine.data('productItem', (products, type, countItems) => ({
    products,
    countItems,
    categoryWasSelected: false,
    additionProducts: [],
    type_id: type.id,
    categoryId: 0,
    offset: OFFSET_STEP,
    activeClassCategory: null,
    // modal
    closeModalClicked: false,
    modalWindow: document.getElementById('zoomModal'),
    modalImg: document.getElementById('zoomImg'),
    countHandler(){
      return this.countItems > Object.keys(this.products).length + this.additionProducts.length
    },
    prepareProductsForCandybar(item){
      return item.products[Object.keys(item.products)[0]]
    },
    addProducts() {
      const url = '/add-products/'
      post(url + this.type_id, {
        offset: this.offset,
        category_id: this.categoryId
      })
        .then(res => {
          this.offset += OFFSET_STEP
          this.additionProducts = [...this.additionProducts, ...res.products]
          this.countItems = res.items_count === 0 ? countItems : res.items_count
        })
    },
    selectCategory(id, key = null) {
      if (this.categoryId !== id && type.is_candybar === 0) {
        this.categoryWasSelected = true
        this.products = {}
        this.categoryId = id
        this.additionProducts = []
        this.offset = 0
        this.addProducts()
        this.activeClassCategory = key
      }
    },
    zoomImage(el){
      this.closeModalClicked = false
      const currentImg = el.parentElement.nextElementSibling
      this.modalWindow.style.display = 'block'
      this.modalImg.src = currentImg.src
      this.modalImg.alt = currentImg.alt
    },
    closeZoomModal(){
      this.closeModalClicked = true
      setTimeout(() => this.modalWindow.style.display = 'none', 400)
    }
  }))
})

Alpine.data('testimonialItem', (itemsCount) => ({
  newComments: [],
  wasCommentSent: false,
  isFormOpened: false,
  itemsCount,
  formData: {
    author_name: null,
    estimation: null,
    description: null
  },
  mouseOver: {
    1: false,
    2: false,
    3: false,
    4: false,
    5: false
  },
  animationStep: 0,
  animationItemWidth: 288,
  param: 3,
  init(){
    const width = window.innerWidth
    const widthLg = 1024
    if(width <= widthLg){
      this.param = 1
    }
  },
  increaseAnimationStep(){
    if(this.itemsCount > this.animationStep + this.param){
      this.animationStep++
    }
  },
  decreaseAnimationStep(){
    if(this.animationStep > 0){
      this.animationStep--
    }
  },
  starMouseLeave(index){
    if(!this.formData.estimation){
      for (var key in this.mouseOver) {
        this.mouseOver[key] = false
      }
    } else if(index > this.formData.estimation) {
      this.mouseOver[index] = false
      for (var key in this.mouseOver) {
        if(this.formData.estimation < key)
        this.mouseOver[key] = false
      }
    }
  },
  starMouseEnter(index){
    for (var key in this.mouseOver) {
      if(key <= index)
      this.mouseOver[key] = true
    }
  },
  chooseEstimation(index){
    this.formData.estimation = index
    for (var key in this.mouseOver) {
      if(this.formData.estimation < key)
      this.mouseOver[key] = false
    }
  },
  formSubmit(){
    if(this.checkValidation()){
      post('/testimonial/create', {...this.formData})
        .then(data => {
          this.newComments.push(data)
          this.itemsCount++
          this.isFormOpened = false
          this.formData = {
            author_name: null,
            estimation: null,
            description: null
          }
        })
    }
  },
  checkValidation(){
    return true
  },
  checkEstimation(estimation, item){
    return 'none'
  }
}))

Alpine.start();
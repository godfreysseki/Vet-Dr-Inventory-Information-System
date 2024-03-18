(function($) {
  'use strict';
  
  $(document).ready(function() {
    activateMenu();
    orderTracking();
    subscribeToNews();
  });
  
  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim();
    if (all) {
      return [...document.querySelectorAll(el)];
    }
    else {
      return document.querySelector(el);
    }
  };
  
  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all);
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener));
      }
      else {
        selectEl.addEventListener(type, listener);
      }
    }
  };
  
  /**
   * Easy on scroll event listener
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener);
  };
  
  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header');
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled');
      }
      else {
        selectHeader.classList.remove('header-scrolled');
      }
    };
    window.addEventListener('load', headerScrolled);
    onscroll(document, headerScrolled);
  }
  
  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile');
    this.classList.toggle('bi-list');
    this.classList.toggle('bi-x');
  });
  
  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top');
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active');
      }
      else {
        backtotop.classList.remove('active');
      }
    };
    window.addEventListener('load', toggleBacktotop);
    onscroll(document, toggleBacktotop);
  }
  
  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault();
      this.nextElementSibling.classList.toggle('dropdown-active');
    }
  }, true);
  
  /**
   * Testimonials slider
   */
  new Swiper('.testimonials-slider', {
    speed: 600, loop: true, autoplay: {
      delay: 5000, disableOnInteraction: false,
    }, slidesPerView: 'auto', pagination: {
      el: '.swiper-pagination', type: 'bullets', clickable: true,
    },
  });
  
  /**
   * Animation on scroll
   */
  window.addEventListener('load', () => {
    AOS.init({
      duration: 1000, easing: 'ease-in-out', once: true, mirror: false,
    });
  });
  
  const tooltipTriggerList = document.querySelectorAll(
      '[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(
      tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
  
  // Load More Events Button
  $(document).ready(function() {
    const productsContainer = $('.events');
    const loadMoreButton = $(
        '<div class="more-container text-center"><button type="button" class="btn btn-sm btn-success btn-more"><span>Load More...</span><i class="icon-long-arrow-right"></i></button></div>');
    const productsPerPage = 6;
    let currentPage = 1;
    
    // Hide all products initially
    $('.post-entry').hide();
    
    // Initial load of products
    showEvents(currentPage);
    
    // Append "View More Products" button
    productsContainer.after(loadMoreButton);
    
    // Handle click on "View More Products" button
    loadMoreButton.on('click', function() {
      currentPage++;
      showEvents(currentPage);
    });
    
    function showEvents(page)
    {
      const start = (page - 1) * productsPerPage;
      const end = start + productsPerPage;
      
      $('.post-entry').slice(start, end).show();
      
      // If no more products to show, hide the "View More Products" button
      if (end >= $('.post-entry').length) {
        loadMoreButton.hide();
      }
    }
  });
  // Load More Products Button
  $(document).ready(function() {
    const productsContainer = $('.products');
    const loadMoreButton = $(
        '<div class="more-container mb-5 text-center"><button type="button"' +
        ' class="btn btn-sm btn-success btn-more"><span>Load More' +
        ' Products...</span><i' +
        ' class="icon-long-arrow-right"></i></button></div>');
    const productsPerPage = 6;
    let currentPage = 1;
    
    // Hide all products initially
    $('.product').hide();
    
    // Initial load of products
    showProducts(currentPage);
    
    // Append "View More Products" button
    productsContainer.after(loadMoreButton);
    
    // Handle click on "View More Products" button
    loadMoreButton.on('click', function() {
      currentPage++;
      showProducts(currentPage);
    });
    
    function showProducts(page)
    {
      const start = (page - 1) * productsPerPage;
      const end = start + productsPerPage;
      
      $('.product').slice(start, end).show();
      
      // If no more products to show, hide the "View More Products" button
      if (end >= $('.product').length) {
        loadMoreButton.hide();
      }
    }
  });
  
  // Activate Active Menu
  function activateMenu(){
    // Activate current menu item based on URL
    var url = window.location.href;
    $('#navbar ul a').filter(function() {
      return this.href == url;
    }).addClass('active');
  }
  
  // Add to cart and shopping
  $(document).on('click', '.addToCart', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.ajax({
      url: 'cart_add.php',
      type: 'POST',
      data: {id: id},
      success: function(response) {
        countCart();
        alert(response);
      },
    });
  });
  
  // Display Item count in cart
  $(document).ready(function() {
    countCart();
    updateSummary();
    searchProducts();
  });
  
  function countCart()
  {
    $.ajax({
      url: 'cart_count.php', type: 'GET', success: function(response) {
        $('.cart_count').html(response);
      },
    });
  }
  
  // Working on increment and decrement of qty in cart
  $(document).on('click', '.decrementBtn, .incrementBtn', function() {
    var row = $(this).closest('tr');
    var spinner = row.find('.qtySpinner');
    var currentQty = parseInt(spinner.val());
    var cart_id = $(this).data('id');
    var price = parseInt(
        row.find('.selling_price').text().replace('UGX ', '').replace(',', ''));
    
    if ($(this).hasClass('decrementBtn')) {
      var newVal = currentQty - 1;
      if (newVal >= 0) {
        spinner.val(newVal);
        var subTotal = newVal * price;
        row.find('.sub-total').text(numberWithCommas(subTotal));
        updateSummary();
        updateCart(cart_id, 'Minus');
      }
    }
    else {
      if ($(this).hasClass('incrementBtn')) {
        var newVal = currentQty + 1;
        spinner.val(newVal);
        var subTotal = newVal * price;
        row.find('.sub-total').text(numberWithCommas(subTotal));
        updateSummary();
        updateCart(cart_id, 'Add');
      }
    }
  });
  
  // Update QTY in cart on spinning
  function updateCart(cartId, signs)
  {
    $.ajax({
      url: 'cart_update.php',
      type: 'post',
      data: {cartId: cartId, signs: signs},
      success: function(response) {
        // Handle the response from the server if needed
        console.log('Cart updated successfully');
        // You can update the UI or perform other actions as necessary
      },
      error: function(xhr, status, error) {
        console.error('Error updating cart:', error);
        // Handle errors if needed
      },
    });
  }
  
  // Auto Spinner Sizing
  $(document).on('input', '.qtySpinner', function() {
    var $input = $(this);
    var value = $input.val();
    var width = (value.length * 35) + 'px'; // Adjust the multiplier as needed
    
    $input.closest('.input-group').css('width', width);
  });
  
  // Function to add commas to numbers for better readability
  function numberWithCommas(x)
  {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
  
  // Function to update summary
  function updateSummary()
  {
    var totalProducts = $('.cart-table tbody tr').length;
    var totalQuantity = 0;
    var totalPrice = 0;
    
    $('.cart-table tbody tr').each(function() {
      var quantity = parseInt($(this).find('.qtySpinner').val());
      var price = parseInt($(this).
          find('.selling_price').
          text().
          replace('UGX ', '').
          replace(',', ''));
      totalQuantity += quantity;
      totalPrice += quantity * price;
    });
    
    // Update summary paragraphs
    $('.total-products').text('Total Products: ' + totalProducts);
    $('.total-quantity').text('Total Quantity: ' + totalQuantity);
    $('.total-price').text('Total Price: UGX ' + numberWithCommas(totalPrice));
  }
  
  // Search for the products
  function searchProducts() {
    $('#productSearch').on('keyup', function() {
      var searchValue = $(this).val().toLowerCase();
      $('.product').each(function() {
        var productName = $(this).data('name');
        if (productName.includes(searchValue)) {
          $(this).show();
        }
        else {
          $(this).hide();
        }
      });
    });
  }
  
  // Remove product from Cart
  $(document).on('click', '.removeCart', function() {
    var product = $(this).data('product');
    var cartId = $(this).data('id');
    var button = $(this); // Reference to the button clicked
    if (confirm('Are you sure you want to remove ' + product + ' from Cart?')) {
      $.ajax({
        url: 'cart_remove.php',
        type: 'post',
        data: {cartId: cartId},
        success: function(response) {
          // remove the row from the table
          button.closest('tr').remove();
          // Update the Order Summary
          updateSummary();
        },
      });
    }
  });
  
  // track online order
  function orderTracking(){
    $(document).on('keyup', '.online_order_status_number', function(){
      var order_number = $(this).val();
      $.ajax({
        url: 'order_info.php',
        type: 'POST',
        data: {order_number: order_number},
        success: function(response){
          $('.order-master').html(response);
        }
      });
    });
  }
  
  function subscribeToNews(){
    $(document).on('submit', '.newsletter_subscription', function(e) {
      e.preventDefault();
  
      let thisForm = this;
      
      let action = thisForm.getAttribute('action');
      let email = $('#email').val();
      $.ajax({
        url: action,
        type: 'post',
        data: {email: email},
        success: function(response) {
          alert(response);
        }
      });
    });
  }
  
})(jQuery);
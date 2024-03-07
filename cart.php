<?php
  include_once "includes/webHeader.inc.php";
?>

<main id="main">
  
  <!-- ======= Blog Section ======= -->
  <section class="hero-section inner-page">
    <div class="wave">
      
      <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z" id="Path"></path>
          </g>
        </g>
      </svg>
    
    </div>
    
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <div class="row justify-content-center">
            <div class="col-md-7 text-center hero-text">
              <h1 data-aos="fade-up" data-aos-delay="">Shopping Cart</h1>
              <p class="mb-5" data-aos="fade-up" data-aos-delay="100">Review your order and adjust when needed before submission.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  
  </section>
  
  <!-- ======= Cart Section ======= -->
  <section class="section cart">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <!-- Cart Items -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <!-- Example item -->
                  <tr>
                    <td><img src="https://via.placeholder.com/150" alt="Product Image" width="50"></td>
                    <td>Product Name</td>
                    <td>UGX 25,000</td>
                    <td>
                      <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button">-</button>
                        <input type="text" class="form-control" value="1">
                        <button class="btn btn-outline-secondary" type="button">+</button>
                      </div>
                    </td>
                    <td>UGX 25,000</td>
                    <td><button class="btn btn-danger">Remove</button></td>
                  </tr>
                  <!-- End Example item -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- End Cart Items -->
        </div>
        <div class="col-lg-4">
          <!-- Cart Summary -->
          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Cart Summary</h2>
              <!-- Summary details will be displayed here -->
              <p>Total Items: 1</p>
              <p>Total Price: UGX 25,000</p>
              <a href="checkout.php" class="btn btn-primary">Checkout</a>
            </div>
          </div>
          <!-- End Cart Summary -->
        </div>
      </div>
    </div>
  </section>
  <!-- End Cart Section -->

</main><!-- End #main -->

<?php
  include_once "includes/webFooter.inc.php";
?>
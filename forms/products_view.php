<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Products();
  $items = $data->productDetails($_POST['dataId']);
  
  if (!isset($items[1])) {
    echo '<p>No sales made for the selected product/item.</p>';
    return false;
  }
  
  $sold = '';
  $no = 1;
  $sales = $items[1];
  foreach ($sales as $sale) {
    $sold .= '<tr><td>'.$no.'</td><td>'.orderNumbering($sale['order_id']).'</td><td>'.$sale['quantity'].'</td><td>'.$sale['unit_price'].'</td><td>'.$sale['total_amount'].'</td></tr>';
    $no++;
  }
  
  echo '<div class="row">
          <div class="col-sm-12">
            <h6 class="font-weight-bold">Sales Made</h6>
            <div class="table-responsive">
              <table class="table table-sm table-hover table-bordered table-striped dataTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Order No</th>
                    <th>Quantity</th>
                    <th>Selling Price</th>
                    <th>Total Amount</th>
                  </tr>
                </thead>
                <tbody>
                  '.$sold.'
                </tbody>
              </table>
            </div>
          </div>
        </div>';
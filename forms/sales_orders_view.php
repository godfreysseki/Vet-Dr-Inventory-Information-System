<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new SalesOrder();
  $items = $data->getOrderItems($_POST['dataId']);
  
  $no   = 1;
  $list = "";
  foreach ($items as $item) {
    $list .= "<tr><td>" . $no . "</td><td>" . $item['product_name'] . "</td><td>" . number_format($item['quantity'], 2) . "</td><td>" . number_format($item['price'], 2) . "</td><td>" . number_format($item['quantity'] * $item['price'],
        2) . "</td></tr>";
    $no++;
  }
  echo "<div class='table-responsive'>
          <table class='table table-sm table-striped table-hover table-bordered dataTable'>
            <thead>
              <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Selling Price</th>
                <th>Sub-Total</th>
              </tr>
            </thead>
            <tbody>
              " . $list . "
            </tbody>
          </table>
        </div>";
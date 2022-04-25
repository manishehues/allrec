<?php
if (!defined('ABSPATH')) exit;

//require_once 'affiliates-menus.php';

?>
<h1>Tickets</h1>

<div id="pricing" class="pricingListing quoteTable">
    <table id="records_table" class="costListing table-1">

        <thead>
            <tr>
                <td>Serial no</td>
                <td>Order ID</td>
                <td>Tickets</td>
                <td>Ticket used</td>
                <td>Date</td>

            </tr>
        </thead>

        <tbody>

            <?php if ($rowcount == 0) { ?>
                <tr>
                    <td colspan="6">
                        <?php echo "No Data Found."; ?>
                    </td>
                </tr>
            <?php
            } else { ?>
                <?php $count = 1; ?>
                <?php

                foreach ($tickets as $res) { ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $res->order_id; ?></td>
                        <td><?php echo $res->ticket_number; ?></td>
                        <td>
                            <?php
                            if ($res->is_used == 1) :
                                echo "used";
                            else :
                                echo "-";

                            endif

                            ?>
                        </td>
                        <td><?php echo date('D d M Y - h:i A', strtotime($res->created_at)) ?></td>
                    </tr>

            <?php $count++;
                }
            } ?>

        </tbody>
    </table>
    <div style="width: 100%;float: left;">
        <?php
        echo '<ul class="pagination admin-pagination" style="margin: 10px;">';
        if ($page > 1) {
            echo '<li><a style ="padding: 5px;"  href="' . site_url("/my-account") . '/user-tickets/?pg=' . ($page - 1) . '">prev </a></li>';
        }
        for ($i = 1; $i <= $total_page; $i++) {
            if ($i == $page) {
                $active = "active";
            } else {
                $active = "";
            }
            echo '<li style ="padding: 5px;" class="' . $active . '"><a href="' . site_url("/my-account") . '/user-tickets/?pg=' . $i . '" >' . $i . '</a></li>';
        }

        if ($total_page > $page) {
            echo '<li><a style ="padding: 5px;"  href="' . site_url("/my-account") . '/user-tickets/?pg=' . ($page + 1) . '">next </a></li>';
        }
        echo '</ul>';
        ?>
    </div>

</div>
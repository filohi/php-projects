<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
            .green {
                color:green;
            }
            .red {
                color:red;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- YOUR CODE -->
                <?php 
                foreach (getCsv() as $csv){
                    echo '<tr>';
                    echo "<td>" . formatDate($csv['Date']) . "</td>";
                    echo "<td>" . $csv['Check #'] . "</td>";
                    echo "<td>" . $csv['Description'] . "</td>";
                    echo "<td class='" . getClass($csv['Amount']) . "'>" . $csv['Amount'] . "</td>";
                    echo '</tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>$<?= getPositive();?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>$<?= getNegative();?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>$<?= getTotal();?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="min.css"> 
    </head>
    <body>
        <form method='post'>
            <aside>
                <div id='div'>
                    <h3>IS&T Ticketing System</h3>


                

                    <title>Home Page</title>
         
              
                    <br><br><br>

                    <a href="tkt-form.php"><button class="btn" type="button">Create Ticket</button></a>
                    <br><br>

                    <a href="tkt-view.php"><button class="btn" type="button">Show Tickets</button></a>
                    <br><br>

                    <a href="search.php"><button class="btn" type="button">Search Ticket</button></a>
                    <br><br>

          
                        <a href="status.php"><button class="btn" type="button">Status Ticket</button></a>
                        <br><br>
                     
                </div>
            </aside>
        </form>
    </body>
</html>

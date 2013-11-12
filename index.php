<?php
// load everything
include_once 'private/core/core.php';
?>
<html>
    <head>                       
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
    </head>
    <body>
        <?php
        print "hello";
        print CountryDropdown::phpCountryDropdown('ES');
        print CountryDropdown::phpCountryDropdown('EN');


        $dbh = connect_db();
        foreach ($dbh->query('SELECT nombre from ejemplos') as $row) {
            print_r($row);
        }
        ?></body>
</html>
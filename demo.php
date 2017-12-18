<?php 
    require_once "./GetContactInfo.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo ContactInfo</title>
</head>
<body>
    <h1>Contact Info demo</h1>
    <h2>the code:</h2>
    <pre>
        &#x3C;?php echo (new ContactInfo(__DIR__.&#x22;/contact.json&#x22;))-&#x3E;printDataInfoHTML_formatList1([&#x22;class&#x22; =&#x3E; &#x22;footerContact&#x22;]);?&#x3E;
    </pre>
    <h2>result:</h2>
    <?php echo (new ContactInfo(__DIR__."/contact.json"))->printDataInfoHTML_formatList1(["class" => "footerContact"]);
            ?>
    <br>
    <h2>Check:</h2>
    <p>think about checking the current dom ==> using the developpers tools of your browser. The class we precised is added. you can add the same fashion the id tag. whatever. hhh </p>
</body>
</html>
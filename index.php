<?php

$products = json_decode(file_get_contents('products.json'),true);

if(isset($_GET['updateIndex']) && isset($_POST['name'])){
    $index = $_GET['updateIndex'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $products[$index]['name'] = $name;
    $products[$index]['price'] = $price;
    
    $newJsonString = json_encode($products);
    file_put_contents('products.json', $newJsonString);
}else if(isset($_POST['add'])) {
    // create
    array_push($products, [
        'id' => count($products),
        'name' => $_POST['name'],
        'price' => $_POST['price'],
    ]);

    
    $newJsonString = json_encode($products);
    file_put_contents('products.json', $newJsonString);
}else if(isset($_POST['delete'])) {
    $index = $_GET["delete"];
    array_splice($products, $index, 1);
    
    $newJsonString = json_encode($products);
    file_put_contents('products.json', $newJsonString);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JSON - CRUD</title>

    <style>
        table.border, table.border th, table.border td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table.border th, table.border td {
            padding: 3px 10px;
        }
    </style>
</head>
<body>

<form action="" method="POST">
    <table>
        <tr> 
            <td><label>Name: </label></td>
            <td><input type='text' name='name'></td>
        </tr>
        <tr> 
            <td><label>Price: </label></td>
            <td><input type='number' name='price'></td>
        </tr>
        <tr> 
            <td></td>
            <td><button type="submit" name="add">Create</button></td>
        </tr>
    </table>
</form>

<table class="border">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Product</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    foreach($products as $product):
    ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td><?= $product['name'] ?></td>
        <td><?= $product['price'] ?></td>
        <td >
            <div style="display: inline-flex">
                <button data-index="<?= $i ?>" data-name="<?= $product['name'] ?>" data-price="<?= $product['price'] ?>" class='edit'>Edit</button>
                <form action="index.php?delete=<?= $i ?>" method="POST">
                    <button type="submit" name="delete" class='delete'>Delete</button>
                </form>
            </div>
        </td>
    </tr>
    <?php 
    $i++;
    endforeach;
    ?>
    </tbody>
</table>

<script>
    let editButtons = document.querySelectorAll('.edit');
    let deleteButtons = document.querySelectorAll('.delete');
    let form = document.querySelector('form')

    for(var i = 0; i<= editButtons.length-1; i++) {
        editButtons[i].addEventListener('click', edit)
        deleteButtons[i].addEventListener('click', del);
    }
    function edit(e) {
        let name = e.target.getAttribute('data-name');
        let price = e.target.getAttribute('data-price');
        let index = e.target.getAttribute('data-index');
        console.log(name)
        form.setAttribute('action', 'index.php?updateIndex='+index)
        form.innerHTML = `
            <table>
                <tr> 
                    <td><label>Name: </label></td>\
                    <td><input type='text' name='name' value='${name}'></td>\
                </tr>
                <tr> 
                    <td><label>Price: </label></td>\
                    <td><input type='number' name='price' value='${price}'></td>\
                </tr>
                <tr> 
                    <td></td>\
                    <td><button type="submit">Update</button></td>\
                </tr>
            </table>
        `
    }

    function del(e) {

    }
</script>

</body>
</html>

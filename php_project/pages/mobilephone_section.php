<?php 
include("db.php");
session_start();

// Fetch mobile products
$mobileQuery = "SELECT name, price, image, description FROM products WHERE category = 'mobile'";
$mobileStmt = $pdo->prepare($mobileQuery);
$mobileStmt->execute();
$mobileProducts = $mobileStmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are no products
if (empty($mobileProducts)) {
    echo "<p>No mobile products available.</p>";
}
?>

<!-- MOBILE PHONE SECTION -->
<div class="product-section" id="product-section-mobile">
    <div class="product-section-top-container">
        <div class="section-category-container">
            <div class="section-category-type">
                <span class="blue-line"></span>
                <span class="section-category-text">Mobile</span>
            </div>
            <h1>Discover Our Mobiles</h1>
        </div>
    </div>
    <div class="product-cards-container" id="product-cards-container">
        <?php foreach ($mobileProducts as $product): ?>
            <li class="product-card">
                <div class="product-image-container">
                    <img src="<?php echo $product['image'];?>" alt="<?php echo $product['image'];?>"">
                </div>
                <div class="product-text-container">
                    <h1><?php echo $product['name'];?></h1>
                    <h2><?php echo $product['description'];?></h2>
                    <p>$<?php echo $product['price'];?></p>
                    <button class="blue-button">Add To Cart</button>
                </div>
            </li>
            <?php endforeach;?>
    </div>
</div>
<!-- END OF MOBILE PHONES COLLECTION -->

<style>
.product-cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    padding: 15px;
    justify-content: center;
}

.product-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.2s;
    height: 350px;
    width: 200px;
    text-align: center;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image-container {
    background-color: rgb(231, 238, 252);
    padding: 20px;
    display: flex;
    border-radius: 15px;
    justify-content: center;
    align-items: center;
    height: 180px;
    width: 60%;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.product-image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease-in-out;
}

.product-image-container img:hover {
    transform: scale(1.1);
}

.product-text-container {
    height: 40%;
    padding: 10px;
    text-align: center;
}

.product-text-container h1 {
    font-size: 18px;
    margin: 5px 0;
    color: #333;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.product-text-container h2 {
    font-size: 10px;
    margin: 5px 0;
    font-weight: normal;
    color: #333;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.product-text-container p {
    font-size: 14px;
    color:  #007bff;
    margin: 5px 0;
}

.blue-button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 15px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 14px;
}

.blue-button:hover {
    background-color: #0056b3;
}
</style>
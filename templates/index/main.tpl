<div class="container py-3">
    <div class="container text-center mt-3">
        <h1>Welcome to GreenLeaf Organic Market</h1>
        <p class="lead text-muted">
            Discover the freshest, ethically sourced organic produce, dairy, grains, and meats.  
            At GreenLeaf, we believe in sustainability, quality, and bringing you nature’s best.<br>  
            🌱 100% Organic & Locally Sourced <br>
            🚚 Fast & Eco-Friendly Delivery <br>
            ❤️ Supporting Sustainable Farming
        </p>
    </div>

    <div class="container mt-5">
        <div class="row">
            {if isset($session.user)}
                <!-- Button to trigger the modal -->
                <div class="col-12 mb-3">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        Create New Product
                    </button>
                </div>
            {/if}
            {foreach $products as $product}
                <div class="col-12 col-md-4 mb-4">
                    <div class="card">
                        {if $product.id >= 1 && $product.id <= 10}
                            <img src="assets/img/items/{$product.id}.jpg" class="card-img-top img-responsive" alt="{$product.name}" style="max-height:406px; min-height:406px;">
                        {else}
                            <img src="assets/img/default.jpg" class="card-img-top img-responsive" alt="{$product.name}" style="max-height:406px; min-height:406px;">
                        {/if}
                        <div class="card-body">
                            <h5 class="card-title">{$product.name}</h5>
                            <h6>£{$product.price}.00</h6>
                            <p class="{if {$product.stock} > 30}text-primary{else} text-danger{/if}">{$product.stock} in stock</p>
                            <div class="text-center">
                                <a class="btn btn-primary" href="/product/{$product.id}">View{if isset($smarty.session.user)}/Edit{/if}</a>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
    <!-- Modal for creating a new product -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Create New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="about" class="form-label">About</label>
                            <textarea class="form-control" id="about" name="about" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                {foreach from=$categories item=category}
                                    <option value="{$category.id}">{$category.name}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create Product</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
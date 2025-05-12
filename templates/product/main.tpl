<div class="container">
    {if $product}
        <div class="py-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    {if $product.id >= 1 && $product.id <= 10}
                        <img src="/assets/img/items/{$product.id}.jpg" class="card-img-top img-responsive" alt="{$product.name}">
                    {else}
                        <img src="/assets/img/default.jpg" class="card-img-top img-responsive" alt="{$product.name}">
                    {/if}
                </div>
                <div class="col-12 col-md-6">
                    <h1 class="pb-1">{$product.name}</h1>
                    <p class="text-muted">{$product.category}</p>
                    <h5 class="pt-3">{$product.about}</h5>
                    <h5 class="pt-3">£{$product.price}.00</h5>
                    <p class="text-primary">In Stock</p>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{$product.stock}">

                    
                    {if isset($smarty.session.user)}
                        <div class="py-3">
                            <!-- DELETE BUTTON -->
                            <form method="POST">
                                <input type="hidden" name="delete" value="1">
                                <button type="submit" class="btn btn-danger">Delete Product</button>
                            </form>

                            <!-- EDIT BUTTON -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                Edit Product
                            </button>

                            <!-- EDIT PRODUCT MODAL -->
                            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <input type="hidden" name="edit" value="1">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control" value="{$product.name}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">About</label>
                                                    <textarea name="about" class="form-control" required>{$product.about}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" class="form-control" required>
                                                        <option value="" disabled>Select Category</option>
                                                        {foreach from=$categories item=category}
                                                            <option value="{$category.id}" {if $category.id == $product.category_id}selected{/if}>{$category.name}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Price</label>
                                                    <input type="number" name="price" class="form-control" value="{$product.price}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" name="stock" class="form-control" value="{$product.stock}" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    {else}
        <div class="text-center">
            <h1>Product not found.</1h>
            <p>Please try again</p>
        </div>
    {/if}
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {

        <!-- Get the quantity input field and retrieve its max stock value -->
        let quantityInput = document.getElementById("quantity");
        let maxStock = parseInt(quantityInput.max);

         <!-- Listen for user input on the quantity field -->
        quantityInput.addEventListener("input", function () {

            <!-- If the entered value exceeds the available stock, set it to the max stock -->
            if (this.value > maxStock) {
                this.value = maxStock;
            } else if (this.value < 1) {
                this.value = 1;
            }
        });
    });
</script>


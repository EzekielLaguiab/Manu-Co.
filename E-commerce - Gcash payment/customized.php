
<?php require 'header.php'; ?>

<style>
.design-selection button {
    background-color: var(--main-color);
    transition: 0.4s all;
    width: 150px;
    height: 40px;
    color: white;
    padding: 10px;
    margin: 5px;
    border-radius: 10px;
    justify-content: space-between;
    text-align: center;
}
.design-selection button:hover {
    background-color: var(--hover-color);
}
.single #wrist_size{
    width: 160px;
}

</style>

<!-- Main content section -->
<section class="single-product my-5 pt-5 mx-40 px-5 container">
    <div class="container">
        <div class="design-selection d-flex mx-auto justify-content-center">
            <button class="design-btn" data-design="design1">DESIGN 1</button>
            <button class="design-btn" data-design="design2">DESIGN 2</button>
            <button class="design-btn" data-design="design3">DESIGN 3</button>
            <button class="design-btn" data-design="design4">DESIGN 4</button>
        </div>
    </div>

    <div id="design1" class="design-content row mt-4 container mx-auto">
        <!-- Design 1 content -->
        <div class="main_image col-lg-5 col-md-6 col-6 position-relative">
            <img class="main_Img img-fluid w-100 pb-1" src="assets/IMAGES/custom1.jpg" alt="Design 1 Image">
        </div>
        <div class="single col-lg-6 col-md-6 col-6">
            <form action="/" method="post">
                <h2>Design 1</h2>
                <label for="wrist_size">Wrist size</label>
                <select id="wrist_size" class="form-select my-2 w-70" name="wrist_size" required>
                    <option value="14cm">14cm</option>
                    <option value="15cm">15cm</option>
                    <option value="16cm">16cm</option>
                    <option value="17cm">17cm</option>
                    <option value="18cm">18cm</option>
                    <option value="19cm">19cm</option>
                </select>
                <label for="stone">Stone/Crystal</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <div class="form-group mt-3">
                    <textarea name="notes" id="notes" class="form-control" placeholder="Add notes here..." cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-3">
                    <input type="number" name="product_quantity" min="1" value="1" class="form-control w-25 d-inline-block" />
                    <button class="btn btn-primary add-to-cart-btn" type="submit" name="add-to-cart">Add to cart</button>
                </div>
            </form>
        </div>
    </div>

    <div id="design2" class="design-content row mt-4 container mx-auto" style="display: none;">
        <!-- Design 2 content -->
        <div class="main_image col-lg-5 col-md-6 col-6 position-relative">
            <img class="main_Img img-fluid w-100 pb-1" src="assets/IMAGES/custom2.jpg" alt="Design 2 Image">
        </div>
        <div class="single col-lg-6 col-md-6 col-6">
            <form action="/" method="post">
                <h2>Design 2</h2>
                <label for="wrist_size">Wrist size</label>
                <select id="wrist" class="form-select my-2 w-70" name="wrist_size" required>
                    <option value="14cm">14cm</option>
                    <option value="15cm">15cm</option>
                    <option value="16cm">16cm</option>
                    <option value="17cm">17cm</option>
                    <option value="18cm">18cm</option>
                    <option value="19cm">19cm</option>
                </select>
                <label for="stone">Stone/Crystal 1</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <label for="stone">Stone/Crystal 2</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <div class="form-group mt-3">
                    <textarea name="notes" id="notes" class="form-control" placeholder="Add notes here..." cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-3">
                    <input type="number" name="product_quantity" min="1" value="1" class="form-control w-25 d-inline-block" />
                    <button class="btn btn-primary add-to-cart-btn" type="submit" name="add-to-cart">Add to cart</button>
                </div>
            </form>
        </div>
    </div>

    <div id="design3" class="design-content row mt-4 container mx-auto" style="display: none;">
        <!-- Design 2 content -->
        <div class="main_image col-lg-5 col-md-6 col-6 position-relative">
            <img class="main_Img img-fluid w-100 pb-1" src="assets/IMAGES/custom3.jpg" alt="Design 3 Image">
        </div>
        <div class="single col-lg-6 col-md-6 col-6">
            <form action="/" method="post">
                <h2>Design 3</h2>
                <label for="wrist_size">Wrist size</label>
                <select id="wrist" class="form-select my-2 w-70" name="wrist_size" required>
                    <option value="14cm">14cm</option>
                    <option value="15cm">15cm</option>
                    <option value="16cm">16cm</option>
                    <option value="17cm">17cm</option>
                    <option value="18cm">18cm</option>
                    <option value="19cm">19cm</option>
                </select>
                <label for="stone">Stone/Crystal 1</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <label for="stone">Stone/Crystal 2</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <label for="stone">Stone/Crystal 3</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <div class="form-group mt-3">
                    <textarea name="notes" id="notes" class="form-control" placeholder="Add notes here..." cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-3">
                    <input type="number" name="product_quantity" min="1" value="1" class="form-control w-25 d-inline-block" />
                    <button class="btn btn-primary add-to-cart-btn" type="submit" name="add-to-cart">Add to cart</button>
                </div>
            </form>
        </div>
    </div>

    <div id="design4" class="design-content row mt-4 container mx-auto" style="display: none;">
        <!-- Design 2 content -->
        <div class="main_image col-lg-5 col-md-6 col-6 position-relative">
            <img class="main_Img img-fluid w-100 pb-1" src="assets/IMAGES/custom4.jpg" alt="Design 4 Image">
        </div>
        <div class="single col-lg-6 col-md-6 col-6">
            <form action="/" method="post">
                <h2>Design 4</h2>
                <label for="wrist_size">Wrist size</label>
                <select id="wrist" class="form-select my-2 w-70" name="wrist_size" required>
                    <option value="14cm">14cm</option>
                    <option value="15cm">15cm</option>
                    <option value="16cm">16cm</option>
                    <option value="17cm">17cm</option>
                    <option value="18cm">18cm</option>
                    <option value="19cm">19cm</option>
                </select>
                <label for="stone">Stone/Crystal 1</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <label for="stone">Stone/Crystal 2</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <label for="stone">Stone/Crystal 3</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <label for="stone">Stone/Crystal 4</label>
                <select id="stone" class="form-select my-2 w-70" name="stone" required>
                    <option value="select">Select</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Rose_quartz">Rose Quartz</option>
                    <option value="Moonstone">Moonstone</option>
                    <option value="Citrine">Citrine</option>
                    <option value="Lapis_lazuli">Lapis Lazuli</option>
                    <option value="Garnet">Garnet</option>
                </select>
                <div class="form-group mt-3">
                    <textarea name="notes" id="notes" class="form-control" placeholder="Add notes here..." cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-3">
                    <input type="number" name="product_quantity" min="1" value="1" class="form-control w-25 d-inline-block" />
                    <button class="btn btn-primary add-to-cart-btn" type="submit" name="add-to-cart">Add to cart</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Similar divs for design3, design4 can be added here with unique IDs and content -->

</section>

<!-- JavaScript for displaying content based on button clicks -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.design-btn');
    const designs = document.querySelectorAll('.design-content');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const targetDesign = button.getAttribute('data-design');

            designs.forEach(design => {
                if (design.id === targetDesign) {
                    design.style.display = 'flex';
                } else {
                    design.style.display = 'none';
                }
            });
        });
    });
});
</script>

<!-- Footer -->
<?php require 'footer.php'; ?>

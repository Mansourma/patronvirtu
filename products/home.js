
    const addToCartButtons = document.querySelectorAll('.add');

    addToCartButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');

            // Send an AJAX request to add the product to the cart
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const cartCount = document.getElementById('cart-count');
                    cartCount.innerText = xhr.responseText;
                }
            };
            xhr.send('product_id=' + productId);
        });
    });


document.addEventListener("DOMContentLoaded", function() {
    var searchForm = document.getElementById("search-form");
    var searchInput = document.getElementById("search-input");
    var searchResults = document.getElementById("search-results");

    searchForm.addEventListener("submit", function(event) {
        event.preventDefault();
        var searchValue = searchInput.value.trim();

        // Send an AJAX request to the server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    displaySearchResults(response);
                } else {
                    console.log("Error: " + xhr.status);
                }
            }
        };

        xhr.open("GET", "productsearch.php?search=" + encodeURIComponent(searchValue), true);
        xhr.send();
    });

    function displaySearchResults(results) {
        searchResults.innerHTML = "";

        if (results.length > 0) {
            for (var i = 0; i < results.length; i++) {
                var result = results[i];
                var card = createCard(result);
                searchResults.appendChild(card);
            }
        } else {
            var noResults = document.createElement("p");
            noResults.textContent = "No results found.";
            searchResults.appendChild(noResults);
        }
    }

    function createCard(product) {
        var card = document.createElement("div");
        card.classList.add("card");

        var image = document.createElement("div");
        image.classList.add("image");

        var imageLink = document.createElement("a");
        imageLink.href = "productdetails.php?id=" + product.product_id;

        var img = document.createElement("img");
        img.src = product.image;
        img.alt = "";

        imageLink.appendChild(img);
        image.appendChild(imageLink);
        card.appendChild(image);

        var caption = document.createElement("div");
        caption.classList.add("caption");

        var productName = document.createElement("div");
        productName.classList.add("product_name");
        productName.textContent = product.product_name;

        var quantity = document.createElement("div");
        quantity.classList.add("quantity");
        quantity.innerHTML = '<i class="fas fa-key"></i>' + product.quantity;

        var rating = document.createElement("p");
        rating.classList.add("rating");
        rating.innerHTML = '<i class="fas fa-star" style="color:#FDCC0D;"></i>'.repeat(5);

        var price = document.createElement("div");
        price.classList.add("price");
        price.innerHTML = "<b>$" + product.price + "</b>";

        if (product.discount > 0) {
            var discount = document.createElement("div");
            discount.classList.add("discount");
            discount.innerHTML = "<b><del>$" + product.discount + "</del></b>";
            caption.appendChild(discount);
        }

        caption.appendChild(productName);
        caption.appendChild(quantity);
        caption.appendChild(rating);
        caption.appendChild(price);
        card.appendChild(caption);

        var addButton = document.createElement("button");
        addButton.classList.add("add");
        addButton.dataset.id = product.product_id;
        addButton.textContent = "Add to cart";
        card.appendChild(addButton);

        return card;
    }
});

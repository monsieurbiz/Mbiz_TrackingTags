# Mbiz_TrackingTags

This extension allows you to add HTML in the bottom of the following pages by default:

* Category view
* Product view
* Homepage
* Checkout success
* Cart

Each tag is parsed by a filter which allows you to put a lot of data in your HTML.  
Example:

```html
<!--
Cart items: {{cart items="sku,name"}}
Cart items count: {{cart attr="items_count"}}

Quote total: {{quote attr="grand_total"}} {{quote attr="quote_currency_code"}}
-->
```

This tag will display:

* A JSON object with the products (sku + name) in the cart. Of course you can add all the attributes in the `quote_item` like: `product_id`, `free_shipping`, `description`, `qty`, `row_total`, `row_total_incl_tax`…
* The number of products in the cart.
* The grand total of the quote. Of course you can use all the attributes in the `quote` like: `customer_email`, `customer_dob`, `customer_is_guest`, `coupon_code`, `customer_taxvat`, `subtotal`, `subtotal_with_discount`…

## License

See [LICENSE](https://raw.githubusercontent.com/monsieurbiz/Mbiz_TrackingTags/master/LICENSE).

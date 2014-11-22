==== Bestseller INSTALLATION GUIDE - Version 1.0 ===

1. Copy all file in app/ to magento root folder.( This do not override any file in your magento)
2. Copy all file in skin/ to magento root folder.( This do not override any file in your magento)
3. Make sure clear cache in admin of magento
4.a If you want to call the module in CMS static page.
- For displaying with autoscrolling: Please insert this code:
{{block type="bestseller/bestseller" show_total = "6" name="bestseller"
template="hm/bestseller.phtml" }}
- For displaying with toolbar:
{{block type="bestseller/bestseller" name="bestseller"
template="hm/bestseller_toolbar.phtml" }}
4.a.For using for all categories page( Filter by each category).
  Please goto /app/design/frondend/default/default/layout/hm/hm_bestseller.xml and remove comment in line 18 and line 23
Note that:
show_total is number of best seller products will be displayed. If you use the dispalying with toolbar, show_total is not necessary, because this mode displays all ordered products and sort by ordered quantity.
please make sure Your store have ordered some products. If your store have not any products that ordered, it means that there is no best seller products.


If you have any problem please email to: support@hello-magento.com
Thanks,
Asia Connect Group

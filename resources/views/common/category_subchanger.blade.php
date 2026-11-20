    <?php
    if(!isset($selected_value)){
        $selected_value = 0;
    }
    
if(!class_exists('Seraj_R')){
    class Seraj_R {
        private static $_items = [];
        
        public static function add($id, $data){
            if(!isset(self::$_items)){
                self::$_items[$id] = [];
            }
            
            self::$_items[$id][] = $data;
        }
        
        public static function get(){
            return self::$_items;
        }
    }
}

$brands = [];
foreach(\App\Brand::all() as $brand){
    if(!$brand->category_id){
        continue;
    }
    
    if(!isset($brands[$brand->category_id])){
        $brands[$brand->category_id] = [];
    }
    
    $brands[$brand->category_id][] = [
            'id' => $brand->id,
            'name' => $brand->getTranslation('name')
        ];
}

    function get_categories_loop ( $category, $parent_id, $steps = 1 ) {
        if ( isset( $category->categories ) && $category->categories ) {
            foreach ( $category->categories as $single ) {
                Seraj_R::add($parent_id,  [
                    'id'   => $single->id,
                    'name' => '&nbsp&nbsp'. str_repeat( 'ــ', $steps * 2 ) . ' ' . $single->getTranslation( 'name' )
                ]);
                if ( isset( $single->categories )) {
                    get_categories_loop( $single, $parent_id, $steps + 1 );
                }
            }
        }
    }

    foreach ( $categories as $category ) {
        $parent_id = $category->id;
        if ( $category->childrenCategories ) {
            
            foreach ( $category->childrenCategories as $single ) {
                Seraj_R::add($parent_id,  [
                    'id'   => $single->id,
                    'name' => $single->getTranslation( 'name' )
                ]);
                

                if ( isset( $single->categories ) && $single->categories ) {
                    get_categories_loop( $single, $parent_id, 1 );
                }
            }
        }

    }
    
    $children = Seraj_R::get();
    ?>
    <script>
        var children_categories = <?php echo json_encode( $children ) ?>;
        var selected_value = <?php echo $selected_value ?>;
        var selected_parent = 0;
        var brands = <?php echo json_encode( $brands ) ?>;
        var selected_brands = [];
        
        if(selected_value){
            jQuery.map(children_categories, function (parent, id) {
                jQuery.map(parent, function (item) {
                    if(selected_value == item['id']){
                        selected_parent = id;
                    }
                });
            });
        }
        
        const display_subcategories = function (e) {
            let val = (selected_parent && typeof e === 'undefined') ? selected_parent : jQuery('[name="subsubcategory_id"]').val();
            selected_parent = val;
            
            if (typeof children_categories[val] === "undefined" || Object.keys(children_categories[val]).length === 0) {
                alert('لا توجد أية تصنيفات فرعية للتصنيف الذي أخترته');
                return;
            }

            if (!val) {
                return;
            }
            let childs = [];
            jQuery.map(children_categories[val], function (item) {
                let prepend = '';
                if(selected_value == item['id']){
                    prepend = ' selected';
                    selected_parent = val;
                }
                childs.push('<option value="' + item['id'] + '"'+prepend+'>' + item['name'] + '</option>');
            });

            let el = jQuery('[name="category_id"]');
            el.html(childs.join("\n"));
            el.selectpicker('refresh');
            
            let brand_el = jQuery('[name="brand_id"]');
            brand_el.html('');
            let brands_list = [];
            
            if(typeof brands[el.val()] !== 'undefined'){
                selected_brands = brands[el.val()];
            }
            
            jQuery.map(selected_brands, function(item){
                 brands_list.push('<option value="' + item['id'] + '">' + item['name'] + '</option>');
            });
            if(brands_list.length > 0){
                brand_el.html(brands_list.join("\n"));
            }
            brand_el.selectpicker('refresh');
            
            
            if(selected_parent){
                jQuery('[name="subsubcategory_id"]').selectpicker('val', selected_parent);
            }

        };
        
        display_subcategories();
        jQuery('[name="subsubcategory_id"]').change(display_subcategories);
    </script>
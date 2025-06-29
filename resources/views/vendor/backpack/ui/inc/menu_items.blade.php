{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href=" # "><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Products" icon="la la-question" :link="backpack_url('product')" />
<x-backpack::menu-item title="Orders" icon="la la-question" :link="backpack_url('order')" />
<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
<x-backpack::menu-item title="Product images" icon="la la-question" :link="backpack_url('product-image')" />
<x-backpack::menu-item title="Product reports" icon="la la-question" :link="backpack_url('product-report')" />
<x-backpack::menu-item title="Reviews" icon="la la-question" :link="backpack_url('review')" />
<x-backpack::menu-item title="Cart items" icon="la la-question" :link="backpack_url('cart-item')" />
<x-backpack::menu-item title="Order items" icon="la la-question" :link="backpack_url('order-item')" />
<x-backpack::menu-item title="Ch favorites" icon="la la-question" :link="backpack_url('ch-favorite')" />
<x-backpack::menu-item title="Ch messages" icon="la la-question" :link="backpack_url('ch-message')" />

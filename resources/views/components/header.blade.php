<header class="fixed-top bg-light navbar-light fixed-bottom border-bottom" style="height: 39px;">
    <div class="container-fluid mx-3" style="width: 98%;">
        <div class="row">
            <div class="col-8 align-self-center">
                <h5 class="card-text pt-1">{{ $pageTitle }}</h5>
            </div>
            <div class="col-2 text-end align-self-center">
                <div class="dropdown">
                    <button class="btn bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Apply Syncing
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" onclick="syncProducts('shopify');" style="cursor:pointer;">Sync
                                Shopify Products</a></li>
                        <li><a class="dropdown-item" onclick="syncProducts('g2a');" style="cursor:pointer;">Sync G2A
                                Products</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-2 text-end align-self-center">
                {!! Form::select('mode',\App\Enum\ModeEnum::getTranslationKeys(),\App\Services\ShopifyService::getStore()->mode,['class'=>'form-control form-control-sm mt-1','placeholder'=>'Select Mode','onChange'=>'changeMode(this);']) !!}
            </div>
        </div>
    </div>
</header>

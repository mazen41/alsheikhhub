<!-- mobilemenu -->
<div class="mobilemenu">
  <div class="mobilemenu__backdrop"></div>
  <div class="mobilemenu__body">
    <div class="mobilemenu__header">
      <div class="mobilemenu__title">الأقسام</div><button type="button" class="mobilemenu__close"><svg width="20px" height="20px">
          <use xlink:href="layout/citylolo/images/sprite.svg#cross-20"></use>
        </svg></button>
    </div>
    <div class="mobilemenu__content">
      <ul class="mobile-links mobile-links--level--0" data-collapse data-collapse-opened-class="mobile-links__item--open">
        {{-- @foreach() --}}
          <li class="mobile-links__item" data-collapse-item>
            <div class="mobile-links__item-title"><a href="section</?= $sect['sect_id'] ?>.html" class="mobile-links__item-link">category</a> <button class="mobile-links__item-toggle" type="button" data-collapse-trigger><svg class="mobile-links__item-arrow" width="12px" height="7px">
                  <use xlink:href="layout/citylolo/images/sprite.svg#arrow-rounded-down-12x7"></use>
                </svg></button></div>
            <div class="mobile-links__item-sub-links" data-collapse-content>
              <ul class="mobile-links mobile-links--level--1">
                {{-- @foreach() --}}
                  <li class="mobile-links__item" data-collapse-item>
                    <div class="mobile-links__item-title"><a href="#" class="mobile-links__item-link">subcategory</a> <button class="mobile-links__item-toggle" type="button" data-collapse-trigger><svg class="mobile-links__item-arrow" width="12px" height="7px">
                          <use xlink:href="layout/citylolo/images/sprite.svg#arrow-rounded-down-12x7"></use>
                        </svg></button></div>
                    <div class="mobile-links__item-sub-links" data-collapse-content>
                      <ul class="mobile-links mobile-links--level--2">
                        {{-- @foreach() --}}
                          <li class="mobile-links__item" data-collapse-item>
                            <div class="mobile-links__item-title"><a href="#" class="mobile-links__item-link">subsubcategory</a></div>
                          </li>
                        {{-- @endforeach --}}
                      </ul>
                    </div>
                  </li>
                {{-- @endforeach --}}
              </ul>
            </div>
          </li>
        {{-- @endforeach --}}
      </ul>
    </div>
  </div>
</div><!-- mobilemenu / end -->
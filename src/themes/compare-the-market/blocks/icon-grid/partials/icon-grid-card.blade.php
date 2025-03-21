<div class="icon-grid-card d-flex flex-column align-items-center text-center">
  <div class="icon-grid-card-icon mb-10 p-10 text-secondary bg-neutral-5 radius-round">
    <x-icon :acf="$grid_item['icon']"/>
  </div>
  <div class="icon-grid-card-title h5 text-primary">{{ $grid_item['title'] }}</div>
  <div class="icon-grid-card-content">{{ $grid_item['content'] }}</div>
</div>

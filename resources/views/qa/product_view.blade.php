<div class="row">
    <div class="col-12">
        <table class="tab-bordered table">
            <tr>
                <th width="20">Title</th>
                <td>{{ $product->title }}</td>
                <th width="20">Category</th>
                <td>{{ $product->category->title }}</td>
            </tr>
            <tr>
                <th>Condition</th>
                <td>{{ $product->condition }}</td>
                <th>Value</th>
                <td>{{ $product->value }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $product->location }}</td>
                <th>Description</th>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <th>Images</th>
                <td colspan="3">
                    <?php $images = explode(',' , $product->images); ?>
                    @foreach($images as $image)
                        <img class="border-dark border" src="{{ asset('product_images/'.$image) }}" width="200">
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
</div>

<table>
  <thead>
      <tr>
          <th>Tên sản phẩm</th>
          <th>Ảnh</th>
          <th>ID Danh Mục</th>
          <th>ID Thương Hiệu</th>
          <th>ID Nhãn</th>
          <th>Loại Trừ</th>
          <th>Giá Gốc</th>
          <th>Giá Giảm</th>
          <th>Số Lượng</th>
      </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
      <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $product->image }}</td>
        <td>{{ $product->category_id }}</td>
        <td>{{ $product->brand_id }}</td>
        <td>{{ $product->tags->pluck('id')->implode(', ') }}</td>
        <td>{{ $product->excerpt }}</td>
        <td>{{ number_format($product->price_regular) }}</td>
        <td>{{ number_format($product->price_sale) }}</td>
        <td>{{ $product->quantity }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
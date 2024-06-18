@foreach ($categories as $category)
    @if ($category->category_id == $parent_id)
        <option value="{{ $category->id }}">{{ $char . $category->name }}</option>
        @include('blog::partials.children_categories', ['categories' => $categories, 'parent_id' => $category->id, 'char' => $char.'|---'])
    @endif
@endforeach
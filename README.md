# CasualWP - Element

Create HTML elements easily with PHP.

## Examples

### Self-closing element
```php
$image = new CasualWP\Element('img', ['src' => 'https://via.placeholder.com/1920x1080']);
$image->render();
```

```html
<img src="https://via.placeholder.com/1920x1080">
```


### Element with content
```php
$paragraph =  new CasualWP\Element('p', [], ['This is paragraph.']);
$paragraph->render();
```

```html
<p>This is paragraph.</p>
```

### Element with CasualWP element as the content
```php
$list_item_01 = new CasualWP\Element('li', ['class' => 'list-item'], ['This is list item #1']);
$list_item_02 = new CasualWP\Element('li', ['class' => 'list-item'], ['This is list item #2']);

$list = new CasualWP\Element('ul', ['class' => 'list'], [
    $list_item_01,
    $list_item_02,
]);
$list->render();
```

```html
<ul class="list">
    <li class="list-item">This is list item #1</li>
    <li class="list-item">This is list item #2</li>
</ul>
```
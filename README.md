# Twig 3.24 + Symfony 7: Enterprise UI Component Demo

This project demonstrates the "gold standard" for building strictly-typed, high-performance UI components using **Twig 3.24.0** and **Symfony 7.4+**. It showcases modern templating features that bridge the gap between backend data structures and reactive frontend frameworks.

## 🚀 Key Features

- **Strictly Typed DTOs**: Utilizing PHP 8.2 `readonly` classes for immutable, validated view data.
- **Smart HTML Attributes**: Using `html_attr()` to intelligently merge classes and handle boolean attributes.
- **Framework-Safe Escaping**: Leveraging `html_attr_relaxed` to preserve `@click`, `:disabled`, and `x-data` syntax for Vue.js/Alpine.js.
- **Null-Safe Short-Circuiting**: Demonstrating the improved Twig `?.` operator that matches PHP 8's behavior.
- **Object Destructuring**: Extracting and renaming properties from DTOs directly within Twig templates.

## 🛠️ Requirements

- PHP 8.2 or higher
- Composer
- Symfony CLI (optional, for local server)

## 📦 Installation

1. Clone the repository:
   ```bash
    git clone https://github.com/mattleads/Twig3_24.git
    cd Twig3_24
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

## 🏗️ Architecture

### 1. The Data Layer (DTOs)
Located in `src/DTO/UI/`, these classes ensure that data entering the view is validated and predictable.

```php
readonly class ButtonComponentDto {
    public function __construct(
        #[Assert\Choice(['primary', 'secondary'])]
        public string $type,
        public ButtonStateDto $state,
        public ButtonMetaDto $meta,
        public ?ButtonThemeDto $theme = null,
    ) {}
}
```

### 2. The Controller
Uses `#[MapRequestPayload]` to automatically hydrate and validate DTOs from incoming JSON.

```php
#[Route('/ui/preview/button', methods: ['POST'])]
public function preview(#[MapRequestPayload] ButtonComponentDto $payload): Response {
    return $this->render('ui/components/preview.html.twig', ['payload' => $payload]);
}
```

### 3. The Twig Component
The component (`templates/ui/components/_button.html.twig`) uses the new `html_attr` function:

```twig
{# Merge base, variant, and framework attributes seamlessly #}
<button {{ html_attr(base_attrs, variant_attrs, framework_attrs) }}>
    <slot>{{ button_label|default('Click Here') }}</slot>
</button>
```

## 🧪 Testing & Verification

### CLI Verification
Run the built-in command to see the Twig features in action across different data scenarios:
```bash
php bin/console app:verify-twig
```

### Web Verification (Interactive Demo)
1. Start the local Symfony server:
   ```bash
   symfony server:start -d
   ```
   *(Or use `php -S localhost:8000 -t public` if you don't have Symfony CLI)*

2. Open your browser and navigate to:
   [http://localhost:8000/ui/preview/button](http://localhost:8000/ui/preview/button)

   **Interactive Demo:** Click the "Submit Order" button on the page. The page will reload and simulate a submitted form state, instantly demonstrating Twig 3.24's conditional attribute merging (`html_attr()`), dynamic CSS class toggling, and boolean attribute toggling (`disabled`).

3. **Custom Payload API Testing:** You can also test the component programmatically by sending a `POST` request with a custom JSON payload:
   ```bash
   curl -X POST http://localhost:8000/ui/preview/button \
     -H "Content-Type: application/json" \
     -d '{
       "type": "danger",
       "state": {"disabled": false, "loading": true},
       "meta": {"analyticsId": "btn_delete", "ariaLabel": "Delete Item"}
     }'
   ```

### Functional Tests
Run the PHPUnit suite to verify the Controller's payload handling and HTML rendering:
```bash
php bin/phpunit
```


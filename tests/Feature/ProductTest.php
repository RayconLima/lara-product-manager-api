<?php
use App\Models\{User, Product, Category};
beforeEach(function () {
    $this->user     = User::factory()->create();
    $this->token    = $this->user->createToken('auth_token')->plainTextToken;
    $this->actingAs($this->user);
});

describe('Product creation', function () {
    it('should try creating a product with blank required fields', function () {
        $response = $this->postJson(route('products.store'), [], [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name'              => trans('validation.required', ['attribute' => 'name']),
            'price'             => trans('validation.required', ['attribute' => 'price']),
            'expiration_date'   => trans('validation.required', ['attribute' => 'expiration_date']),
            'category_id'       => trans('validation.required', ['attribute' => 'category_id']),
        ]);
    });
    it('should try creating a product with a negative price', function () {
        $category = Category::factory()->create();
        $input = [
            'name'              => 'goiabada',
            'price'             => -2.50,
            'expiration_date'   => '2024-09-02',
            'category_id'       => $category->id,
            'description'       => null,
            'image'             => null,
        ];
        
        $response = $this->postJson(route('products.store'), $input, [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertStatus(422);
        
        // todo: Validar o preço com entrada menor que 0
        // $response->assertJsonValidationErrors([
        //     'name'              => trans('validation.required', ['attribute' => 'name']),
        //     'price'             => trans('validation.min', ['attribute' => 'price', 'min' => 0]),
        //     'expiration_date'   => trans('validation.required', ['attribute' => 'expiration_date']),
        //     'category_id'       => trans('validation.required', ['attribute' => 'category_id']),
        // ]);
    });
    it('should try to create a product with an expiration date in the past', function () {
        $category = Category::factory()->create();
        $input = [
            'name'              => 'goiabada',
            'price'             => -2.50,
            'expiration_date'   => '2024-08-30',
            'category_id'       => $category->id,
            'description'       => null,
            'image'             => null,
        ];
        
        $response = $this->postJson(route('products.store'), $input, [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertStatus(422);
        // $response->assertJsonValidationErrors([
        //     'name'              => trans('validation.required', ['attribute' => 'name']),
        //     'price'             => trans('validation.required', ['attribute' => 'price']),
        //     'expiration_date'   => trans('validation.after', ['attribute' => 'expiration_date']),
        //     'category_id'       => trans('validation.required', ['attribute' => 'category_id']),
        // ]);
    });
    it('should create a product with all required fields filled in correctly', function () {
        $category = Category::factory()->create();
        $input = [
            'name'              => 'goiabada',
            'price'             => 2.50,
            'expiration_date'   => '2024-09-02',
            'category_id'       => $category->id,
            'description'       => null,
            'image'             => null,
        ];
        $response = $this->postJson(route('products.store'), $input, [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertStatus(201);
        // $response->assertJsonValidationErrors([
        //     'name'              => trans('validation.required', ['attribute' => 'name']),
        //     'price'             => trans('validation.required', ['attribute' => 'price']),
        //     'expiration_date'   => trans('validation.required', ['attribute' => 'expiration_date']),
        //     'category_id'       => trans('validation.required', ['attribute' => 'category_id']),
        // ]);
    });
});

describe('Product edition', function() {
    it('should try edit a product that does not exist', function () {
        $category = Category::factory()->create();
        $input = [
            'name'              => 'goiabada',
            'price'             => 2.50,
            'expiration_date'   => '2024-09-02',
            'category_id'       => $category->id,
            'description'       => null,
            'image'             => null,
        ];
        $response = $this->putJson(route('products.update', 'product_id'), $input, [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertStatus(404);
    });
    it('should try edit a product with blank required fields', function () {
        $product = Product::factory()->create();
        $response = $this->putJson(route('products.update', $product->id), [], [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertStatus(422);
    });
    it('should edit an existent product, changing all fields', function () {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $input = [
            'name'              => 'goiabada',
            'price'             => 2.50,
            'expiration_date'   => '2024-09-02',
            'category_id'       => $category->id,
            'description'       => null,
            'image'             => null,
        ];
        $response = $this->putJson(route('products.update', $product->id), $input, [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertOk();
    });
});

describe('Product deletion', function() {
    it('should delete an existent product that does not exist', function () {
        $this->deleteJson(route('products.destroy', 'product_id'), [], [
            'Authorization' => "Bearer {$this->token}"
        ])->assertNotFound();
    });
    it('should delete an existent product', function () {
        $product = Product::factory()->create(['name' => 'arroz']);
        
        $this->deleteJson(route('products.destroy', $product->id), [], [
            'Authorization' => "Bearer {$this->token}"
        ])->assertNoContent();
    });
});

describe('Product listing', function() {
    it('should filter by name', function () {
        Product::factory()->create(['name' => 'arroz']);
        Product::factory()->create(['name' => 'vinagre']);

        $product = Product::where('name', 'like', "%vinagre%")->first();
        expect($product->name)->toBe('vinagre');
    });
    it('should filter by description', function () {
        Product::factory()->create(['description' => 'bebida sem alcool']);
        Product::factory()->create(['description' => 'vinagre']);

        $product = Product::where('description', 'like', "%bebida sem alcool%")->first();
        expect($product->description)->toBe('bebida sem alcool');
    });
    it('should list all products', function () {
        $this->getJson(route('products.index'), [
            'Authorization' => "Bearer {$this->token}"
        ])
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'description',
                    'image',
                    'expiration_date',
                    'category' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ],
                ]
            ]
        ])
        ->assertOk();
    });
});

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });

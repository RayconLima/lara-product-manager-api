<?php
use App\Models\User;

// use function Pest\Laravel\{}

beforeEach(function () {
    $this->user     = User::factory()->create();
    $this->token    = $this->user->createToken('auth_token')->plainTextToken;
});

describe('Product creation', function () {
    it('should try creating a product with blank required fields');
    it('should try creating a product with a negative price');
    it('should try to create a product with an expiration date in the past');
    it('should create a product with all required fields filled in correctly');
});

describe('Product edition', function() {
    it('should try edit a product that does not exist');
    it('should try edit a product with blankk required fields');
    it('should edit an existent product, changing all fields');
});

describe('Product deletion', function() {
    it('should delete an existent product that does not exist');
    it('should delete an existent product');
});

describe('Product listing', function() {
    it('should filter by category');
    it('should sort products by name, price, expiration date');
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

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

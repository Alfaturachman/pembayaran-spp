<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    /**
     * Skenario Positif (Happy Path):
     * Menguji bahwa password polos (plain text) di-hash menggunakan Bcrypt saat di-assign ke attribute password.
     */
    public function test_password_attribute_hashes_plain_text_password()
    {
        $user = new User();
        $user->password = 'secret123';

        // Memastikan password ter-hash dan cocok saat diverifikasi dengan Hash::check
        $this->assertNotEquals('secret123', $user->password);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    /**
     * Skenario Negatif / Edge Case 1:
     * Menguji bahwa password yang sudah berupa hash Bcrypt (diawali $2y$) tidak akan di-hash ulang (double hashing).
     */
    public function test_password_attribute_does_not_double_hash_already_hashed_password()
    {
        $existingHash = '$2y$04$eImiTXuWVxfM37uY4JANjQ==examplehashvaluehere';
        
        $user = new User();
        $user->password = $existingHash;

        // Memastikan nilai hash tetap sama tanpa di-hash ulang
        $this->assertEquals($existingHash, $user->password);
    }

    /**
     * Skenario Negatif / Edge Case 2:
     * Menguji bahwa mengeset password bernilai null atau string kosong tidak mengubah nilai attribute password yang ada.
     */
    public function test_password_attribute_ignores_null_or_empty_string()
    {
        $user = new User();
        $user->password = 'initialPass123';
        $initialHash = $user->password;

        // Mengeset string kosong
        $user->password = '';
        $this->assertEquals($initialHash, $user->password);

        // Mengeset null
        $user->password = null;
        $this->assertEquals($initialHash, $user->password);
    }

    /**
     * Skenario Positif (Happy Path):
     * Menguji bahwa fillable attribute didefinisikan dengan benar dan mengizinkan mass assignment field yang sesuai.
     */
    public function test_user_fillable_attributes_contain_expected_fields()
    {
        $user = new User();
        $expectedFillable = [
            'nisn',
            'name',
            'username',
            'email',
            'password',
            'address',
            'phone_number',
            'class',
            'roles',
        ];

        $this->assertEquals($expectedFillable, $user->getFillable());
    }
}

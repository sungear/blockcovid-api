<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Citoyen;

class CitoyenTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register_new_citoyen()
    {
        $citoyen = Citoyen::factory()->first_registration_or_id_lost()->make();
        $citoyen_array = [
            'id_citoyen' => $citoyen->id_citoyen,
            'token_fcm' => $citoyen->token_fcm,
        ];        
        $this->assertNull($citoyen_array['id_citoyen']);

        $response = $this->json('POST', '/api/citoyens/enregistrement', $citoyen_array)
        ->seeJson([
            'status' => 201
        ])->response->getContent();
        $this->assertNotNull(json_decode($response)->id_citoyen);
        $this->seeInDatabase('pfe.citoyens', ['token_fcm' => $citoyen->token_fcm]); 
    }
    
    public function test_citoyen_send_new_fcm_token()
    {
        $citoyen = Citoyen::factory()->create();   
        $this->seeInDatabase('pfe.citoyens', ['token_fcm' => $citoyen->token_fcm, 
        'id_citoyen' => $citoyen->id_citoyen]);

        $new_token_citoyen = Citoyen::factory()->new_fcm_token($citoyen)->make();
        $citoyen_array = [
            'id_citoyen' => $citoyen->id_citoyen,
            'token_fcm' => $new_token_citoyen->token_fcm,
        ];
        $this->assertEquals($citoyen_array['id_citoyen'], $citoyen->id_citoyen);
        $this->assertNotEquals($citoyen_array['token_fcm'], $citoyen->token_fcm);

        $response = $this->json('PUT', '/api/citoyens/mise-a-jour', $citoyen_array);

        $this->seeInDatabase('pfe.citoyens', ['token_fcm' => $citoyen_array['token_fcm'], 
        'id_citoyen' => $citoyen_array['id_citoyen']]);
    }  
    
    public function test_citoyen_scan_qr_code_medecin()
    {
        
    } 
    
    public function test_citoyen_scan_qr_code_etablssement()
    {
        
    }  
    
    public function test_citoyen_id_lost()
    {
        
    } 
   
}

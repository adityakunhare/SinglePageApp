<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Carbon\Carbon;
use Carbon\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Symfony\Component\HttpFoundation\Response;

class ContactsTest extends TestCase
{
    use RefreshDatabase; //Used to clean the datbase on every test run

    protected $user;
    
    protected function setUp(): void //This function runs before each test
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

    }

    /** @test */
    public function a_list_of_contacts_can_be_fetched_for_authenticated_user(){

        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id'=>$user->id]);
        
        $anotherContact = factory(Contact::class)->create(['user_id'=>$anotherUser->id]);
        
        $response = $this->get('/api/contacts?api_token='.$user->api_token);

        $response->assertJsonCount(1)
            ->assertJson([
                'data'=> [ 
                    [
                        'data'=> [
                            'contact_id'=> $contact->id,
                        ],
                    ]
                ]
            ] );
    }
    
    /** @test */
    public function an_authenticated_user_can_add_a_contact()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/api/contacts',$this->data());

        $contact = Contact::first();

        $this->assertEquals('John Doe', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('10/10/1992', $contact->birthday->format('d/m/Y'));
        $this->assertEquals('ABC Company', $contact->company);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data'=> [
                'contact_id'=> $contact->id,
                // 'name' => $contact->name,
                // 'email'=> $contact->email,
                // 'birthday'=> $contact->birthday->format('m/d/Y'),
                // 'company'=> $contact->company,
                // 'last_updated'=> $contact->updated_at->diffForHumans(),
            ],
            'links'=> [
                'self'=> $contact->path(),
            ]
        ]);
    }


   /** @test */
   public function an_unauthenticated_user_should_redirect_to_login()
   {
       $response = $this->post('/api/contacts', array_merge($this->data(),['api_token'=>'']));

       $response->assertRedirect('/login');
       $this->assertCount(0,Contact::all());

   }

    /** @test */
    public function fields_are_required()
    {
        collect(['name','email','birthday','company'])
            ->each(function($field){
                $response = $this->post('/api/contacts',
                array_merge($this->data(),[$field=>'']) );

                $response->assertSessionHasErrors($field);
                $this->assertCount(0,Contact::all());
            });
    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/contacts',
        array_merge($this->data(),['email'=>'NOT AN EMAIL']) );

        $response->assertSessionHasErrors('email');
        $this->assertCount(0,Contact::all());
    }

    /** @test */
    public function birthdays_are_properly_stored()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/contacts', array_merge($this->data()));

        $this->assertCount(1,Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('10/10/1992', Contact::first()->birthday->format('d/m/Y'));
    }

    /** @test */
    public function a_contact_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create(['user_id'=> $this->user->id]);

        $response = $this->get('/api/contacts/'. $contact->id.'?api_token='.$this->user->api_token);


        $response->assertJson([
            'data'=> [
                'contact_id' => $contact->id,
                'name'=> $contact->name,
                'email'=> $contact->email,
                'birthday' => $contact->birthday->format('d/m/Y'),
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans(),
            ]
        ]);
        
    }

    /** @test */
    public function only_the_user_contacts_can_be_retrieved(){

        $contact = factory(Contact::class)->create();
        $anotherUser = factory(User::class)->create();
        
        $response = $this->get('/api/contacts/'. $contact->id.'?api_token='.$anotherUser->api_token);

        $response->assertStatus(403);



    }

    /** @test */
    public function a_contact_can_be_patched(){

        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create( ['user_id'=> $this->user->id]);

        $response = $this->patch('/api/contacts/'. $contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('John Doe', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('10/10/1992', $contact->birthday->format('d/m/Y'));
        $this->assertEquals('ABC Company', $contact->company);
        $response->assertStatus(200);
        $response->assertJson([
            'data'=> [
                'contact_id'=> $contact->id,
            ],
            'links'=> [
                'self'=> $contact->path(),
            ]
        ]);
    }

    /** @test */
    public function only_owner_of_the_contact_can_patch_the_contact(){

        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/contacts/'.$contact->id, array_merge($this->data(),['api_token'=> $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_contact_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create(['user_id'=> $this->user->id]);

        $response = $this->delete('/api/contacts/'.$contact->id,['api_token'=> $this->user->api_token]);

        $this->assertCount(0,Contact::all()); 
        $response->assertStatus(204);
       
    }

    /** @test */
    public function only_the_owner_can_delete_the_contact(){

        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/contacts/'.$contact->id,['api_token'=> $anotherUser->api_token]);

        $response->assertStatus((403));
    }



    private function data(){
        return  [
                'name' => 'John Doe',
                'email' => 'test@test.com',
                'birthday' => '10/10/1992',
                'company' => 'ABC Company',
                'api_token'=> $this->user->api_token
        ];
    }
}

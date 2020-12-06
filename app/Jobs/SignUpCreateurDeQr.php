<?php

namespace App\Jobs;

class SignUpCreateurDeQr extends Job
{
    private $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CreateurDeQr $createur_de_qr, Chapter $chapter, Author $author, Tag $tag)
    {   
        $createur_de_qr = 
        $createur_de_qr->id_createur_qr = $request->id_createur_qr;
        $createur_de_qr->email = $request->email;
        $createur_de_qr->mot_de_passe = $request->mot_de_passe;        
        $createur_de_qr->type = $request->type;

        $createur_de_qr->save();

        $chapters = $chapter->processFromFile($this->request['chapters']);
        $new_book = $book->create($this->request);
        $authors = $author->find($this->request['authors']);
        $tags = $tag->find($tags);

        $new_book->chapters()->createMany($chapters);
        $new_book->authors()->attache($authors);
        $new_book->tags()->attache($tags);
    }
}
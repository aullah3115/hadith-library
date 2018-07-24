<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\BookInterface;
use App\Eloquent\Entities\Book;
//use App\Validators\Eloquent\BookValidator;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BookRepository extends BaseRepository implements BookInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    public function getAll(){
        $books = $this->model->with('author')->get();
        return $books;
    }

    public function updateBook($data){
        $book = $this->model->find($data['book_id']);
        
        $book->name = $data['name'];
        $book->author_id = $data['author_id'];

        $book->save();
        $book->load('author');
        
        return $book;
    }

    public function addBook($data){
        $book = $this->model->create($data);
        $book->load('author');

        return $book;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}

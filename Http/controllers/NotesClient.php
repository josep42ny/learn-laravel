<?php

namespace Http\controllers;

use Core\Validator;
use Http\dao\NoteDao;
use Http\dao\NoteDaoFactory;

class NotesClient
{
  private NoteDao $service;

  public function __construct()
  {
    $this->service = NoteDaoFactory::assemble();
  }

  public function getAll(): void
  {

    dd(getallheaders()['Authorization']);

    $data = [
      'notes' => $this->service->getAll(1)
    ];

    $this->respond($data);
  }

  public function getOne(array $params)
  {
    if (!Validator::integer($params['id'])) {
      abort(400);
    }



    $this->respond(
      [
        'notes' => $this->service->get($params['id'])
      ]
    );
  }

  public function store()
  {
    // TODO: Validator::note($params['note']);

    dd(file_get_contents('php://input'));
  }

  public function destroy($params)
  {
    if (!Validator::integer($params['id'])) {
      abort(400);
    }

    $this->service->delete($params['id']);
    $this->respond([], 201);
  }

  private function respond($data, $statusCode = 200): void
  {
    header('Content-Type: application/json');
    http_response_code($statusCode);

    $json = json_encode($data);
    view('api/json.php', ['json' => $json]);
    die();
  }
  /*
  public function create(): void
  {
    view('notes/create.view.php', [
      'heading' => 'Create a note',
      'errors' => [],
    ]);
  }
  public function destroy(): void
  {
    $authorisedUser = Session::get('user')['id'];

    $nid = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $note = $this->service->get($nid);

    authorise($note->getUserId() === $authorisedUser);

    $this->service->delete($nid);
    redirect('/notes');
  }

  public function edit(): void
  {
    $authorisedUser = Session::get('user')['id'];

    $nid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $note = $this->service->get($nid);

    authorise($note->getUserId() === $authorisedUser);

    view('notes/edit.view.php', [
      'heading' => 'Edit note',
      'errors' => [],
      'note' => $note,
    ]);
  }

  public function index()
  {
    $authorisedUser = Session::get('user')['id'];
    $notes = $this->service->getAll($authorisedUser);
    view('notes/index.view.php', [
      'heading' => 'My Notes',
      'notes' => $notes,
    ]);
  }

  public function show(): void
  {
    $authorisedUser = Session::get('user')['id'];

    $nid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $note = $this->service->get($nid);

    authorise($note->getUserId() === $authorisedUser);

    view('notes/show.view.php', [
      'heading' => 'Note',
      'note' => $note,
    ]);
  }
  public function store(): void
  {
    $authorisedUser = Session::get('user')['id'];

    $errors = [
      'title' => [],
      'body' => [],
    ];

    if (!Validator::string($_POST['title'], 1, 50)) {
      array_push($errors['title'], 'Invalid title lenght.');
    }

    if (!Validator::string($_POST['body'], 1, 1000)) {
      array_push($errors['body'], 'Invalid body lenght.');
    }

    $hasError = false;
    foreach ($errors as $error) {
      if (!empty($error)) {
        $hasError = true;
        break;
      }
    }

    if ($hasError) {
      view('notes/create.view.php', [
        'heading' => 'Create a note',
        'errors' => $errors,
      ]);
    }

    $this->service->store($_POST['title'], $_POST['body'], $authorisedUser);
    redirect('/notes');
  }
  public function update(): void
  {
    $authorisedUser = Session::get('user')['id'];

    $errors = [
      'title' => [],
      'body' => [],
    ];

    $nid = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $note = $this->service->get($nid);

    authorise($note->getUserId() === $authorisedUser);

    if (!Validator::string($_POST['title'], 1, 50)) {
      array_push($errors['title'], 'Invalid title lenght.');
    }

    if (!Validator::string($_POST['body'], 1, 1000)) {
      array_push($errors['body'], 'Invalid body lenght.');
    }

    $hasError = false;
    foreach ($errors as $error) {
      if (!empty($error)) {
        $hasError = true;
        break;
      }
    }

    if ($hasError) {
      view('notes/edit.view.php', [
        'heading' => 'Edit note',
        'errors' => $errors,
        'note' => $note,
      ]);
    }

    $this->service->update($_POST['title'], $_POST['body'], $_POST['id']);
    redirect('/notes');
  }
*/
}

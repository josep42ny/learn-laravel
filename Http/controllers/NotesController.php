<?php

namespace Http\controllers;

use Core\Session;
use Core\Validator;
use Core\View;
use Http\dao\NoteDao;
use Http\dao\NoteDaoFactory;
use Http\model\Note;
use Http\model\User;

class NotesController
{
  private NoteDao $service;

  public function __construct()
  {
    $this->service = NoteDaoFactory::assemble();
  }
  public function create(): void
  {
    View::html('notes/create.view.php', [
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

    View::html('notes/edit.view.php', [
      'heading' => 'Edit note',
      'errors' => [],
      'note' => $note,
    ]);
  }

  public function index()
  {
    $authorisedUser = Session::get('user')['id'];
    $notes = $this->service->getAll($authorisedUser);

    View::html('notes/index.view.php', [
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

    View::html('notes/show.view.php', [
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
      View::html('notes/create.view.php', [
        'heading' => 'Create a note',
        'errors' => $errors,
      ]);
    }

    $this->service->store(new Note(-1, $_POST['title'], $_POST['body'], $authorisedUser));
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
      View::html('notes/edit.view.php', [
        'heading' => 'Edit note',
        'errors' => $errors,
        'note' => $note,
      ]);
    }

    $this->service->update(new Note($_POST['id'], $_POST['title'], $_POST['body'], -1));
    redirect('/notes');
  }
}

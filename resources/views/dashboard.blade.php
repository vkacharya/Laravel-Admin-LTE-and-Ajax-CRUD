@extends('layouts.app')

{{--
Okay done now you need to create here two modules
1. Student -> id, image, name, address, contact, documents (user can add multiple files here only PDF allow)
2. Stream -> id, student id, stream type (it, doctor, engineeer, etc), is_active

You need to create these two section in the admin panel Did you get it? From where user will enter data in this

User will enter data from admin panel In admin panel you need to create CRUD of these two module

But using AJAX.

Your directory structure will be like these
pages->students->index.blade.php
pages->students->create.blade.php

You need to manage all the things related to student module manage from these two file
in the index file only your table there
in the create file you have manage add, update and delete functionality using modal
make sure add and update record should be manage in the one modal one form

this same instuction for stream module
you need to create students table, Student model, StudnetController you can use resource
same for stream

did you understand task?yes ma'am can i use one form for student-stream like for index and edit-insert

one form for student create and student update
one form for strean create and strean update did you get?yes ma'am


okay start work on it do not remove these instuction OKAy ma'am comment out it send your workload ok --}}

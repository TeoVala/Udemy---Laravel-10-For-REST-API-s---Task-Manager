<?php

namespace Test\Unit\Models;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class CommentTest extends TestCase {
    public function test_tasks_can_have_comments() {

        $task = Task::factory()->create();

        $comment = $task->comments()->make([
            'content' => 'Task comment',
        ]);

        $comment->user()->associate($task->creator);

        $comment->save();

        $this -> assertModelExists($comment);
    }

    public function test_projects_can_have_comments() {

        $project = Project::factory()->create();

        $comment = $project->comments()->make([
            'content' => 'Project comment',
        ]);

        $comment->user()->associate($project->creator);

        $comment->save();

        $this -> assertModelExists($comment);
    }
}

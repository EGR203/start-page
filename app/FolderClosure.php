<?php
namespace App;

use Franzose\ClosureTable\Models\ClosureTable;

/**
 * App\FolderClosure
 *
 * @property int $ancestor
 * @property int $depth
 * @property int $descendant
 * @mixin \Eloquent
 */
class FolderClosure extends ClosureTable implements FolderClosureInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'folder_closure';
}

<?php

namespace App\Admin\Controllers;

use App\Models\Question;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Table;

class QuestionController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('问题列表');
            $content->description('用户提出的问题');

            $csrf = csrf_token();

            $script = <<<EOT
$('#pjax-container').on('click', '.remove-answer', function() {
  var that = $(this);
  var id = that.data('id');
  $.post('/admin/answers/' + id, { _method: 'delete', _token: '$csrf' }, function(res) {
    if (res.status) {
      that.parents('tr')[0].remove();
    }
  });
}).on('click', '.show-markdown-modal', function() {
  var that = $(this);
  console.log(that.data('title'));
  var title = atob(that.data('title'));
  var content = atob(that.data('markdown'));
  $('#markdown-modal-title').text(title);
  $('#markdown-modal-content').text(content);
  $('#markdown-modal').modal('show');
});
EOT;

            $content->body($this->grid());
            Admin::script($script);
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑问题');
            $content->description('编辑问题');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('新建问题');
            $content->description('创建新问题');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Question::class, function (Grid $grid) {
            $grid->model()->with('user')->with('answers')->with('answers.user');

            $grid->id('ID')->sortable();

            $grid->column('提问人')->display(function () {
                return $this->user['name'];
            });

            $grid->title('标题');
            $grid->column('内容')->display(function () {
                return '<button class="btn btn-primary btn-xs show-markdown-modal" data-markdown="'. base64_encode($this->body) .'" data-title="'. base64_encode($this->title) .'">显示</button>';
            });
            $grid->vote_count('投票数');
            $grid->accept_answer('已解决')->display(function ($answer) {
                if ($answer) {
                    return '<i class="fa fa-check-circle" style="color: green"></i>';
                } else {
                    return '<i></i>';
                }
            });
            $grid->answer_count('答案数')->expand(function () {
                $answers = array_map(function ($item) {
                    $action_remove = '<a href="javascript:void(0)" data-id="'. $item['id']  .'" class="remove-answer"><i class="fa fa-trash"></i></a>';
                    $action_view = '<a href="'. route('questions.show', $item['question_id']). '#answer'. $item['id'] .'" target="_blank"><i class="fa fa-eye"></i></a>';
                    $actions = $action_remove . $action_view;
                    return [$item['id'], $item['user']['name'], $item['vote_count'],
                        $item['is_accepted'] ? '<i class="fa fa-check-circle" style="color: green"></i>' : '',
                        $item['created_at'],
                        $actions];
                }, $this->answers);

                return new Table(['ID', '回答者', '投票数', '已采纳', '回答时间', '动作'], $answers);
            }, function () {
                return $this->answer_count;
            });

            $grid->created_at('创建时间')->sortable();
            $grid->updated_at('最后更新')->sortable();

            $grid->actions(function ($actions) {
                $actions->append('<a href="'. route('questions.show', $actions->getKey()) .'" target="_blank"><i class="fa fa-eye"></i></a>');
            });

            $grid->tools(function ($tools) {
                $modal = <<<EOT
<div class="modal fade" id="markdown-modal" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
         <h4 class="modal-title" id="markdown-modal-title"></h4>
      </div>
      <div class="modal-body" id="markdown-modal-content">
    
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
EOT;

                $tools->append($modal);
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Question::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

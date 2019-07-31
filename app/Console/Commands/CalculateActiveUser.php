<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    // 供调用的命令
    protected $signature = 'larabbs:calculate-active-user';

    // 命令描述
    protected $description = '生成活跃用户';

    // 最终执行方法
    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("开始计算...");

        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成！");
    }
}

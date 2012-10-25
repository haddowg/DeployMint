<?php

class DeployMintProjectTools
{
    private static $git = 'git';

    public static function setGit($git)
    {
        self::$git = $git;
    }

    public static function getGit()
    {
        return self::$git;
    }

    public static function isGitRepo($dir)
    {
        $res = self::git("branch 2>&1", $dir);
        if (preg_match('/fatal/', $res)) {
            return false;
        }
        return true;
    }

    public static function getRemoteNames($dir)
    {
        $list = self::git('remote', $dir);
        $listArr = preg_split('/[\r\n\s\t\*]+/', $list);
        $clean = array();
        foreach($list as $li) {
            $name = trim($li);
            if (strlen($name)>0 && !in_array($name, $clean)) {
                $clean[] = $name;
            }
        }
        return $clean;
    }

    public static function remoteExists($dir, $remoteName='origin')
    {
        return in_array($remoteName, self::getRemoteNames($dir));
    }

    public static function fetch($dir, $remoteName='origin')
    {
        if (self::remoteExists($dir, $remoteName)) {
            return self::git("fetch $remoteName", $dir);
        }
    }

    public static function getAllBranches($dir)
    {
        $branchList = self::git('branch -a', $dir);
        $branchList = preg_replace('/\(no branch\)/', '', $branchList);
        $branches = preg_split('/[\r\n\s\t\*]+/', $branchList);
        $clean = array();
        foreach($branches as $b) {
            $name = trim(preg_replace('/(remotes\/[^\/]*\/)?/', '', $b));
            if (strlen($name)>0 && !in_array($name, $clean)) {
                $clean[] = $name;
            }
        }
        return $clean;
    }

    public static function branchExists($dir, $branch)
    {
        return in_array($branch, self::getAllbranches($dir));
    }

    public static function git($cmd, $dir)
    {
        $git = self::$git;
        return self::mexec("$git $cmd 2>&1", $dir);
    }

    protected static function mexec($cmd, $cwd = './', $env = null, $timeout = null)
    { // TODO: Put this somewhere it can be used by all DeployMint classes
        $dspec = array(
            0 => array("pipe", "r"), //stdin
            1 => array("pipe", "w"), //stdout
            2 => array("pipe", "w") //stderr
        );
        $proc = proc_open($cmd, $dspec, $pipes, $cwd);
        if ($timeout != null) {
            stream_set_timeout($pipes[1], $timeout);
            stream_set_timeout($pipes[2], $timeout);
        }
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $ret = proc_close($proc);
        return $stdout . $stderr;
    }
}
<?php

/**
 * Maze
 */
class MazeGenerator
{
    public $maze = array();
    public $countOutput = 1;
    public $direction = ['D', 'R', 'U', 'L'];
    public $x = 0;
    public $y = 1;
    public $mazeSize = 15 * 15;
    
    public function __construct($size = null)
    {
        $this->mazeSize = ($size * $size);
        echo '<style>.wall{width:15px;height:5px;float:left}</style>';
        for ($a = 0; $a < $this->countOutput; $a++) {
            if ($size < 3) {
                return false;
            }
            for ($x = 0; $x < $size; $x++) {
                for ($y = 0; $y < $size; $y++) {
                    $this->maze[$a][$x][$y] = '@';
                }
            }
        }
    }
    public function setPosition($x = 0, $y = 1)
    {
        $this->x = $x;
        $this->y = $y;
    }
    public function validate($block, $x, $y)
    {
        foreach ($this->direction as $direction) {
            switch ($direction) {
                case 'D':
                    $y1 = $y + 1;
                    $y2 = $y + 2;
                    if ($x > 0 && $y1 > 0) {
                        if (isset($this->maze[$block][$x][$y1]) && isset($this->maze[$block][$x][$y2])) {
                            $wall = $this->maze[$block][$x][$y1];
                            $wall2 = $this->maze[$block][$x][$y2];
                            if ($wall == '@' && $wall2 == '@') {
                                if ($this->validateNext($block, $x, $y1)) {
                                    $this->maze[$block][$x][$y1] = ' ';
                                    $this->setPosition($x, $y1);
                                    return true;
                                }
                            }
                        }
                    }
                    break;
                case 'R':
                    $x1 = $x + 1;
                    $x2 = $x + 2;
                    if ($x1 > 0 && $y > 0) {
                        if (isset($this->maze[$block][$x1][$y]) && isset($this->maze[$block][$x2][$y])) {
                            $wall = $this->maze[$block][$x1][$y];
                            $wall2 = $this->maze[$block][$x2][$y];
                            if ($wall == '@' && $wall2 == '@') {
                                if ($this->validateNext($block, $x1, $y)) {
                                    $this->maze[$block][$x1][$y] = ' ';
                                    $this->setPosition($x1, $y);
                                    return true;
                                }
                            }
                        }
                    }
                    break;
                case 'L':
                    $x1 = $x - 1;
                    $x2 = $x - 2;
                    if ($x1 > 0 && $y > 0) {
                        if (isset($this->maze[$block][$x1][$y]) && isset($this->maze[$block][$x2][$y])) {
                            $wall = $this->maze[$block][$x1][$y];
                            $wall2 = $this->maze[$block][$x2][$y];
                            if ($wall == '@' && $wall2 == '@') {
                                if ($this->validateNext($block, $x1, $y)) {
                                    $this->maze[$block][$x1][$y] = ' ';
                                    $this->setPosition($x1, $y);
                                    return true;
                                }
                            }
                        }
                    }
                    break;
                case 'U':
                    $y1 = $y - 1;
                    $y2 = $y - 2;
                    if ($x > 0 && $y1 > 0) {
                        if (isset($this->maze[$block][$x][$y1]) && isset($this->maze[$block][$x][$y2])) {
                            $wall = $this->maze[$block][$x][$y1];
                            $wall2 = $this->maze[$block][$x][$y2];
                            if ($wall == '@' && $wall2 == '@') {
                                if ($this->validateNext($block, $x, $y1)) {
                                    $this->maze[$block][$x][$y1] = ' ';
                                    $this->setPosition($x, $y1);
                                    return true;
                                }
                            }
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        return false;
    }
    public function validateNext($block, $x, $y)
    {
        $count = 0;
        foreach ($this->direction as $direction) {
            switch ($direction) {
                case 'D':
                    $y1 = $y + 1;
                    if (isset($this->maze[$block][$x][$y1])) {
                        $wall = $this->maze[$block][$x][$y1];
                        if ($wall == '@') {
                            $count++;
                        }
                    }
                    break;
                case 'R':
                    $x1 = $x + 1;
                    if (isset($this->maze[$block][$x1][$y])) {
                        $wall = $this->maze[$block][$x1][$y];
                        if ($wall == '@') {
                            $count++;
                        }
                    }
                    break;
                case 'L':
                    $x1 = $x - 1;
                    if (isset($this->maze[$block][$x1][$y])) {
                        $wall = $this->maze[$block][$x1][$y];
                        if ($wall == '@') {
                            $count++;
                        }
                    }
                    break;
                case 'U':
                    $y1 = $y - 1;
                    if (isset($this->maze[$block][$x][$y1])) {
                        $wall = $this->maze[$block][$x][$y1];
                        if ($wall == '@') {
                            $count++;
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        if ($count > 2) {
            return true;
        }
        return false;
    }
    public function create($block)
    {
        $loop = true;
        $this->maze[$block][$this->x][$this->y] = ' ';
        while ($loop == true) {
            if ($this->validate($block, $this->x, $this->y) == false) {
                $loop = false;
            }
        }
    }
    public function display()
    {
        foreach ($this->maze as $block => $maze) {
            $this->create($block);
            shuffle($this->direction);
            $this->setPosition();
        }
        $i = 0;
        foreach ($this->maze as $block => $maze) {
            foreach ($maze as $m) {
                foreach ($m as $n) {
                    if($i <> ($this->mazeSize - 2)){
                        echo '<span class="wall">'.$n.'</span>';
                    }else{
                        echo '<span class="wall">&nbsp;</span>';
                    }
                    $i++;
                }
                echo '<br>';
            }
            echo '<br>';
        }
    }
}
$maze = new MazeGenerator(15);
$maze->display();
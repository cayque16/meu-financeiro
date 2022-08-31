<?php

function getUniqId()
{
    return md5(uniqid(rand(), true));
}
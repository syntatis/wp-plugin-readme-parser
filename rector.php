<?php

use Rector\Arguments\Rector\FuncCall\FunctionArgumentDefaultValueReplacerRector;
use Rector\Arguments\ValueObject\ReplaceFuncCallArgumentDefaultValue;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return static function (RectorConfig $rectorConfig): void {
	$rectorConfig->parallel();
    $rectorConfig->paths([__DIR__ . '/app']);
    $rectorConfig->sets([
		DowngradeLevelSetList::DOWN_TO_PHP_72,
    ]);
	$rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
		'WordPressdotorg\Plugin_Directory\Markdown' => 'Syntatis\WP\PluginReadMeParser\Markdown',
	]);
	$rectorConfig->ruleWithConfiguration(FunctionArgumentDefaultValueReplacerRector::class, [
		new ReplaceFuncCallArgumentDefaultValue(
			'class_exists',
			0,
			'\WordPressdotorg\Plugin_Directory\Markdown',
			'\Syntatis\WP\PluginReadMeParser\Markdown'
		),
	]);
};

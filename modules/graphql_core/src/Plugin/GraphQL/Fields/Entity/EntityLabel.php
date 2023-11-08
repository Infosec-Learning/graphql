<?php

namespace Drupal\graphql_core\Plugin\GraphQL\Fields\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Fields\FieldPluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * @GraphQLField(
 *   id = "entity_label",
 *   secure = true,
 *   name = "entityLabel",
 *   type = "String",
 *   parents = {"Entity"}
 * )
 */
class EntityLabel extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function resolveValues($value, array $args, ResolveContext $context, ResolveInfo $info) {
    if ($value instanceof EntityInterface) {
      /** @var \Drupal\Core\Access\AccessResultInterface $accessResult */
      $accessResult = $value->access('view label', NULL, TRUE);
      $context->addCacheableDependency($accessResult);
      if ($accessResult->isAllowed()) {
        yield $value->label();
      }
      yield NULL;
    }
  }

}

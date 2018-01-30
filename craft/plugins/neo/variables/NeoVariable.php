<?php
namespace Craft;

/**
 * Class NeoVariable
 *
 * @package Craft
 */
class NeoVariable
{
	/**
	 * Deprecated since 1.1.0
	 *
	 * @param Neo_BlockModel $block
	 * @return mixed
	 */
	public function children(Neo_BlockModel $block)
	{
		craft()->deprecator->log('NeoVariable::children()', "<code>craft.neo.children(block)</code> has been deprecated. Use <code>block.children</code> instead.");

		$owner = $block->getOwner();
		$type = $block->getType();
		$field = craft()->fields->getFieldById($type->fieldId);

		$criteria = craft()->elements->getCriteria(Neo_ElementType::NeoBlock);
		$criteria->ownerId = $owner->id;
		$criteria->fieldId = $field->id;
		$criteria->locale = $owner->locale;

		$criteria->descendantOf = $block;
		$criteria->descendantDist = 1;

		return $criteria;
	}

	/**
	 * Deprecated since 1.1.0
	 *
	 * @param Neo_BlockModel $block
	 * @return bool
	 */
	public function hasChildren(Neo_BlockModel $block)
	{
		craft()->deprecator->log('NeoVariable::hasChildren()', "<code>craft.neo.hasChildren(block)</code> has been deprecated. Use <code>block.children.total > 0</code> instead.");

		$criteria = $this->children($block);

		return (bool) $criteria->first();
	}
    
	/**
	 * Get Neo blocks on their own, without requiring an owner element.
	 * If possible, avoid using this function. Neo blocks are supposed to be tied explicitly to elements, and the use of
	 * this function ignores this relationship. Using this function can open you up to all kinds of performance and
	 * unexpected behavioural issues if you're not careful.
	 *
	 * @param array|null $criteria
	 * @return ElementCriteriaModel
	 */
	public function blocks($criteria = null)
	{
		return craft()->elements->getCriteria(Neo_ElementType::NeoBlock, $criteria);
	}
}

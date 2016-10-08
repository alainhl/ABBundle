<?php

namespace AB\ABBundle\Entity;

use AB\ABBundle\Model\TestSuiteInterface;
use AB\ABBundle\Base\TestSuite as BaseTestSuite;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="t_ab_test_suites")
 *
 * @author Nicolas Chambrier <naholyr@gmail.com>
 * @license MIT <http://www.opensource.org/licenses/mit-license.php>
 */
class TestSuite extends BaseTestSuite
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    protected $uid;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="array")
     */
    protected $versions = array();

    /**
     * @ORM\Column(type="array")
     */
    protected $scores = array();

    /**
     * @ORM\Column(type="array")
     */
    protected $replacements;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

}

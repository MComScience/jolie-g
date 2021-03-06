<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 */

namespace common\modules\system\controllers;

use Yii;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use mcomscience\sweetalert2\SweetAlert2;

/**
 * Class CacheController
 *
 * @package backend\controllers
 */
class CacheController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider(['allModels' => $this->findCaches()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Returns array of caches in the system, keys are cache components names, values are class names.
     *
     * @param array $cachesNames caches to be found
     *
     * @return array
     */
    private function findCaches(array $cachesNames = [])
    {
        $caches = [];
        $components = Yii::$app->getComponents();
        $findAll = ($cachesNames == []);

        foreach ($components as $name => $component) {
            if (!$findAll && !in_array($name, $cachesNames)) {
                continue;
            }

            if ($component instanceof Cache) {
                $caches[$name] = ['name' => $name, 'class' => get_class($component)];
            } else if (is_array($component) && isset($component['class']) && $this->isCacheClass($component['class'])) {
                $caches[$name] = ['name' => $name, 'class' => $component['class']];
            } else if (is_string($component) && $this->isCacheClass($component)) {
                $caches[$name] = ['name' => $name, 'class' => $component];
            }
        }

        return $caches;
    }

    /**
     * Checks if given class is a Cache class.
     *
     * @param string $className class name.
     *
     * @return boolean
     */
    private function isCacheClass($className)
    {
        return is_subclass_of($className, Cache::class);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionFlushCache($id)
    {
        if ($this->getCache($id)->flush()) {
            \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('backend', 'Cache has been successfully flushed'));
        };

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return \yii\caching\Cache|null
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    protected function getCache($id)
    {
        if (!in_array($id, array_keys($this->findCaches()))) {
            throw new HttpException(400, 'Given cache name is not a name of cache component');
        }

        return Yii::$app->get($id);
    }

    /**
     * @param $id
     * @param $key
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionFlushCacheKey($id, $key)
    {
        if ($this->getCache($id)->delete($key)) {
            Yii::$app->session->setFlash('alert', [
                'body' => \Yii::t('backend', 'Cache entry has been successfully deleted'),
                'options' => ['class' => 'alert-success'],
            ]);
        };

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $tag
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionFlushCacheTag($id, $tag)
    {
        TagDependency::invalidate($this->getCache($id), $tag);
        Yii::$app->session->setFlash('alert', [
            'body' => \Yii::t('backend', 'TagDependency was invalidated'),
            'options' => ['class' => 'alert-success'],
        ]);

        return $this->redirect(['index']);
    }

    public function actionClearCache($alia = '@frontend',$path = '/web/assets/')
    {
        if ($path !== null){
            $AssetPath = \Yii::getAlias($alia) . '/web/assets/';

            $this->recursiveDelete($AssetPath);

            if (\Yii::$app->cache->flush()) {
                \Yii::$app->session->setFlash('crudMessage', 'Cache has been flushed.');
            } else {
                \Yii::$app->session->setFlash('crudMessage', 'Failed to flush cache.');
            }
        }


        return \Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->referrer);
    }

    public static function recursiveDelete($path)
    {
        if (is_file($path)) {
            return @unlink($path);
        } elseif (is_dir($path)) {
            $scan = glob(rtrim($path, '/') . '/*');
            foreach ($scan as $index => $newPath) {
                self::recursiveDelete($newPath);
            }
            return @rmdir($path);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;
use Cake\ORM\TableRegistry;
use Laminas\Diactoros\Response;
use League\OAuth2\Client\Provider\GenericProvider;
use PragmaRX\Google2FAQRCode\Google2FA;


class ClienteController extends AppController
{
    public function operacion($numero1, $numero2, $operacion)
    {
        $resultado = null;

        // Realizar la operación matemática según el parámetro $operacion
        switch ($operacion) {
            case 'suma':
                $resultado = $numero1 + $numero2;
                break;
            // Puedes agregar más casos para otras operaciones como resta, multiplicación, etc.
            default:
                $resultado = 'Operación no válida';
        }

        // Devolver el resultado en formato JSON
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode(['resultado' => $resultado]));

        return $this->response;
    }


































    
    public function login()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $password = $this->request->getData('password');

            $clienteTable = TableRegistry::getTableLocator()->get('Cliente');
            $cliente = $clienteTable->find()
                ->where(['email' => $email])
                ->first();

            if ($cliente) {
                // Inicio de sesión exitoso
                $this->Auth->setUser($cliente->toArray());
                return $this->redirect(['action' => 'index']);
            } else {
                // Credenciales inválidas
                $this->Flash->error('Credenciales inválidas. Por favor, intenta nuevamente.');
            }
        }
    }
    public function logout()
    {
        $this->Auth->logout();
        return $this->redirect(['controller' => 'Cliente', 'action' => 'login']);
    }


    public function index()
    {
        $cliente = $this->paginate($this->Cliente);

        $this->set(compact('cliente'));
    }

    /**
     * View method
     *
     * @param string|null $id Cliente id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cliente = $this->Cliente->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('cliente'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cliente = $this->Cliente->newEmptyEntity();
        if ($this->request->is('post')) {
            $cliente = $this->Cliente->patchEntity($cliente, $this->request->getData());
            if ($this->Cliente->save($cliente)) {
                $this->Flash->success(__('The cliente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cliente could not be saved. Please, try again.'));
        }
        $this->set(compact('cliente'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cliente id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cliente = $this->Cliente->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cliente = $this->Cliente->patchEntity($cliente, $this->request->getData());
            if ($this->Cliente->save($cliente)) {
                $this->Flash->success(__('The cliente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cliente could not be saved. Please, try again.'));
        }
        $this->set(compact('cliente'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cliente id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cliente = $this->Cliente->get($id);
        if ($this->Cliente->delete($cliente)) {
            $this->Flash->success(__('The cliente has been deleted.'));
        } else {
            $this->Flash->error(__('The cliente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

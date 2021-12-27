<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListPesertaPageController extends Controller
{
   public function index(){
      $username = $this->getUsername();
      $peserta = $this->getPeserta();
      // dd($peserta);
      return view('list-peserta',[
         'username' => $username,
         'peserta' => $peserta,
      ]);
   }

   public function delete($id){
      $member = GroupMember::where('user_id', $id);
      $member->delete();
      return redirect()->back();
   }

   private function getApprovedToken($peserta){
      $query = $this->getRequest();

      for($i=0; $i < count($peserta); $i++){
         $peserta[$i]['requests_acc'] = 0;
      }

      if ($query != NULL){
         for($i=0; $i < count($peserta); $i++){
            for ($j = 0; $j < count($query); $j++){
               if($peserta[$i]['id'] == $query[$j]['user_id']){
                  if($query[$j] == 1) $peserta[$i]['requests_acc']++; 
               }
            }
         }
      }

      return $peserta;

   }

   private function getUserRequest($peserta) {
      $query = $this->getRequest();
      
      for($i=0; $i < count($peserta); $i++){
         $peserta[$i]['requests'] = 0;
      }

      if ($query != NULL){
         for($i=0; $i < count($peserta); $i++){
            for ($j = 0; $j < count($query); $j++){
               if($peserta[$i]['id'] == $query[$j]['user_id']){
                  $peserta[$i]['requests']++; 
               }
            }
         }
      }

      // dd($peserta);
      return $peserta;
   }

   private function getRequest(){
      $query = ModelsRequest::all()->toArray();
      return $query;
   }

   private function getGroupName($peserta){
      $groups = $this->getAllGroups();
      $members = $this->getAllGroupMembers();
      $result = [];
      $i=0;

      foreach ($peserta as $item){
         foreach ($members as $member){
            if ($item['id'] == $member['user_id']){
               array_push($result, $item);
               $result[$i]['group'] = $member['group_id'];
            }
         }
         $i++;
      }

      for ($i=0; $i<count($result); $i++){
         foreach ($groups as $group){
            if ($result[$i]['group'] == $group['id']){
               $result[$i]['group'] = $group['name'];
            }
         }
      }
      return $result;
   }

   private function getAllGroupMembers(){
      $query = GroupMember::all()->toArray();
      return $query;
   }

   private function getAllGroups(){
      $query = Group::all()->toArray();
      return $query;
   }

   private function getPeserta(){
      $query = User::where('role', 0)->get()->toArray();
      $result = $this->getGroupName($query);
      $result = $this->getUserRequest($result);
      $result = $this->getApprovedToken($result);
      return $result;
   }

   private function getUsername(){
      return Auth::user()->name;
   }
}
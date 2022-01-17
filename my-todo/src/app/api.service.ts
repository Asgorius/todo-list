import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map, Observable } from 'rxjs';
import { Todo } from './todo';

@Injectable({
  providedIn: 'root'
})

export class ApiService {
  API_URL = 'http://localhost/api';

  constructor(private http: HttpClient) { }

  public getTodos(): Observable<Todo[]> {
    return this.http.get<any[]>(`${this.API_URL}/todos/`).pipe(
      map(
        res => { 
          let transform_res: Todo[] = [];
          res.forEach(element => {
            let todo : Todo = {
              id: element[0],
              titre: element[1],
              description: element[2],
              modified: element[3],
              completed: element[4] == 0 ? false : true
            }
            transform_res.push(todo);
          }); 
          return transform_res;
        }
      )
    );
  }
}
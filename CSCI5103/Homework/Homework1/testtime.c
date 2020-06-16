#include <stdio.h>
#include <sys/time.h>
#include <unistd.h>

int functioncall(){

}



long nanosec(struct timeval t){ /* Calculate nanoseconds in a timeval structure */

  return((t.tv_sec*1000000+t.tv_usec)*1000);

}



int main(){

  int i,j,res;
  long N_iterations=1000000;
  float SysCallTime, FuncCallTime;
  struct timeval t1, t2;

  /* Find average time for Function call */
  gettimeofday(&t1,NULL);  
  for (i=0;i<N_iterations; i++){ j=functioncall();}
  gettimeofday(&t2,NULL);   
  FuncCallTime = (nanosec(t2) - nanosec(t1))/(N_iterations*1.0);


  /* Find average time for System call */
  gettimeofday(&t1,NULL); 
  for (i=0;i<N_iterations; i++){ j=getppid();}
  gettimeofday(&t2,NULL);   
  SysCallTime = (nanosec(t2) - nanosec(t1))/(N_iterations*1.0);

  printf("Average time for Function call : %f\n", FuncCallTime);
  printf("Average time for System call getpid : %f\n", SysCallTime);
  
  return 0;

}

/*
output:

$ gcc -O0 testtime.c -o testtime 
$ ./testtime 

Average time for Function call : 3.572000
Average time for System call getpid : 50.241001

*/


/* 

 A system call is expected to be significantly more expensive than a 

 procedure call (provided that both perform very little actual computation). 

 A system call involves the following actions, which do not occur during 

 a simple procedure call, and thus entails a high overhead:

 

 - A context switch

 - A trap to a specific location in the interrupt vector

 - Control passes to a service routine, which runs in 'monitor' mode

 
 The monitor determines what system call has occurred

 Monitor verifies that the parameters passed are correct and legal

 
 For your experiment, you should measure the total time for a large 

 number of system/function calls, and then find the average time 

 per call in order to overcome the course resolution of your timing 

 functions. For example, here's a sample code for measuring the time 

 taken for a simple system call and a simple function call:

*/


#include <stdio.h>
#include <sys/time.h>
#include <unistd.h>
#include <pthread.h>

void *go(void *threadid) {
	pthread_exit(NULL);
}

//function for calculating time
long msec(struct timeval t){ 

  return ((t.tv_sec * 1000) + (t.tv_usec / 1000));

}

#define NTHREADS 1000
static pthread_t threads[NTHREADS];

int main(int argc, char **argv){

  //Variables for threads
  int i, rc;
  long exitValue;
  //Variables for time
  float Time;
  struct timeval t1, t2;

  gettimeofday(&t1,NULL);  
  
  for (i = 0; i < NTHREADS; i++){
	  rc = pthread_create(&threads[i], NULL, go, NULL);
  }
  
  for (i = 0; i < NTHREADS; i++){
	  rc = pthread_join(threads[i], NULL);
  }
    
  gettimeofday(&t2,NULL);
  
  Time = msec(t2) - msec(t1);

  printf("Time to create and then join 1000 threads in milliseconds: %f\n", Time);
  
  return 0;

}

/*
output:

$ gcc threads.c -lpthread -o threads
$ ./threads
Time to create and then join 1000 threads in milliseconds: 14.000000
$ ./threads
Time to create and then join 1000 threads in milliseconds: 10.000000
*/


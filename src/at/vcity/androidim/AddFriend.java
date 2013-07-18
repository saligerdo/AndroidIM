package at.vcity.androidim;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.ServiceConnection;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import at.vcity.androidim.interfaces.IAppManager;
import at.vcity.androidim.services.IMService;


public class AddFriend extends Activity {
	
	protected static final int TYPE_FRIEND_USERNAME = 0;
	private EditText friendUserNameText;
	private IAppManager imService;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		
		super.onCreate(savedInstanceState);
	
		setContentView(R.layout.add_new_friend);
		setTitle("Add new friend");
		
		Button addFriendButton = (Button) findViewById(R.id.addFriend);
		Button cancelButton = (Button) findViewById(R.id.cancel);
		friendUserNameText = (EditText) findViewById(R.id.newFriendUsername);
		
		
		addFriendButton.setOnClickListener(new OnClickListener(){

			public void onClick(View arg0) {
				if ( friendUserNameText.length() > 0 )
				{
					Thread thread = new Thread(){
							@Override
							public void run() {
								imService.addNewFriendRequest(friendUserNameText.getText().toString());
							}
						};
					thread.start();	  
					Toast.makeText(AddFriend.this, R.string.request_sent, Toast.LENGTH_SHORT)
					       .show();
					finish();					
				}
				else{					
					showDialog(TYPE_FRIEND_USERNAME);					
				}
			}
			
		});
		
		cancelButton.setOnClickListener(new OnClickListener(){

			public void onClick(View arg0) {
				finish();				
			}
			
		});
		
	
	}
	
	@Override
	protected void onResume() {
	
		super.onResume();
		bindService(new Intent(AddFriend.this, IMService.class), mConnection , Context.BIND_AUTO_CREATE);

	}
	
	@Override
	protected void onPause() {		
		super.onPause();
		unbindService(mConnection);
	}
	
	private ServiceConnection mConnection = new ServiceConnection() {
		
		public void onServiceConnected(ComponentName className, IBinder service) {          
			imService = ((IMService.IMBinder)service).getService();   		
		}
		public void onServiceDisconnected(ComponentName className) {          
			imService = null;
			Toast.makeText(AddFriend.this, R.string.local_service_stopped,
					Toast.LENGTH_SHORT).show();
		}
	};
	
	
	
	 protected Dialog onCreateDialog(int id) {
	        switch (id) 
	        {
	        	case TYPE_FRIEND_USERNAME:
	        	{				 	                 
	        		 return new AlertDialog.Builder(AddFriend.this)
	        			.setTitle(R.string.add_new_friend)
	        			.setMessage(R.string.type_friend_username)
	        			.setPositiveButton(R.string.OK, new DialogInterface.OnClickListener() {
	        				public void onClick(DialogInterface dialog, int whichButton) {
	        				}
	        			})	                
	        			.create();
	        	}
	   
	        
	        	default:
	        			return null;
	        }
	 }


}
